<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use VirtualCard\Exception\Http\ServiceUnavailableHttpException;
use VirtualCard\Repository\VirtualCardRepository;
use VirtualCard\Traits\LoggerTrait;

class DetailController extends AbstractFOSRestController
{
    use LoggerTrait;

    /**
     * Get detail of the virtual card
     *
     * @Annotations\Get("/{reference}", requirements={"reference": "\w+"})
     *
     * @SWG\Tag(name="Virtual Card API")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="JSON Payload",
     *     required=true,
     *     format="application/json",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="reference", type="string", description="Given reference of virtual card"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Operation succeeded",
     *     @SWG\Schema(
     *          type="object",
     *          properties={
     *              @SWG\Property(property="balance", type="integer", description="In penny unit"),
     *              @SWG\Property(property="currency", type="string", description="Creation currency of virtual card"),
     *              @SWG\Property(property="activationDate", type="string", format="YYYY-mm-dd"),
     *              @SWG\Property(property="expireDate", type="string", format="YYYY-mm-dd"),
     *              @SWG\Property(property="cardNumber", type="string", maxLength=16, description="Card number")
     *          }
     *      )
     * )
     *
     * @SWG\Response(
     *     response="404",
     *     description="There is no matching virtual card with given reference",
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
     * @return Response
     */
    public function indexAction(
        Request $request,
        VirtualCardRepository $virtualCardRepository
    ): Response {
        try {
            $virtualCard = $virtualCardRepository->findVirtualCardByRef($request->get('reference')->getData());

            if ($virtualCard === null) {
                $view = $this->view(
                    [
                        'message' => 'Virtual card not found with given reference',
                    ],
                    404
                );

                return $this->handleView($view);
            }

            $view = $this->view($virtualCard, Response::HTTP_OK);

            return $this->handleView($view);
        } catch (Throwable $e) {
            $this->logger->alert($e);

            throw new ServiceUnavailableHttpException();
        }
    }
}
