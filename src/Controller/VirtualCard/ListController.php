<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Knp\Component\Pager\PaginatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use VirtualCard\Exception\Http\BadRequestHttpException;
use VirtualCard\Exception\Http\ServiceUnavailableHttpException;
use VirtualCard\Form\ListVirtualCardType;
use VirtualCard\Repository\VirtualCardRepository;
use VirtualCard\Traits\LoggerTrait;

class ListController extends AbstractFOSRestController
{
    use LoggerTrait;

    /**
     * List virtual cards with given filters
     *
     * @Annotations\Get("/")
     *
     * @SWG\Tag(name="Virtual Card API")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Filters",
     *     required=true,
     *     format="application/json",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="currency", type="string", example="EUR", description="Currency of virtual card", pattern="^(USD|EUR)$"),
     *         @SWG\Property(property="vendor", type="integer", description="Vendor's id"),
     *         @SWG\Property(property="activationDateFrom", type="string", description="Virtual card's activation date from", example="2020-12-11", format="YYYY-mm-dd"),
     *         @SWG\Property(property="activationDateTo", type="string", description="Virtual card's activation date from", example="2020-12-11", format="YYYY-mm-dd"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Operation succeeded.",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(
     *              @SWG\Property(property="processId", type="string"),
     *              @SWG\Property(property="reference", type="string"),
     *              @SWG\Property(property="cardNumber", type="string", maxLength=16),
     *              @SWG\Property(property="cvc", type="string", maxLength=4),
     *              @SWG\Property(property="expireDate", type="string", format="YYYY-mm-dd")
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *     response="400",
     *     description="The data that you send is not valid",
     *     @SWG\Schema(
     *          type="object",
     *          properties={
     *              @SWG\Property(property="message", type="string")
     *          }
     *     )
     * )
     *
     * @SWG\Response(
     *     response="503",
     *     description="A problem(s) occurred",
     *     @SWG\Schema(
     *          type="object",
     *          properties={
     *              @SWG\Property(property="message", type="string")
     *          }
     *     )
     * )
     *
     * @param Request $request
     * @param FormFactoryInterface $formFactory
     * @param VirtualCardRepository $virtualCardRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        FormFactoryInterface $formFactory,
        VirtualCardRepository $virtualCardRepository,
        PaginatorInterface $paginator
    ): Response {
        $form = $formFactory->create(ListVirtualCardType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            try {
                $cardsQuery = $virtualCardRepository->list($form->getData());

                $cards = $paginator->paginate(
                    $cardsQuery,
                    abs($request->query->getInt('page', 1)),
                    abs($request->query->getInt('limit', 10))
                );

                $view = $this->view($cards, Response::HTTP_OK);

                return $this->handleView($view);
            } catch (Throwable $e) {
                $this->logger->alert($e);

                throw new ServiceUnavailableHttpException();
            }
        }

        throw new BadRequestHttpException();
    }
}
