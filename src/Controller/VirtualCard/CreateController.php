<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Throwable;
use VirtualCard\Exception\Http\BadRequestHttpException;
use VirtualCard\Exception\Http\ServiceUnavailableHttpException;
use VirtualCard\Exception\VirtualCard\NoMatchingBucketException;
use VirtualCard\Form\VirtualCardType;
use VirtualCard\Service\VirtualCard\Create\VirtualCardCreateWrapper;
use VirtualCard\Traits\LoggerTrait;

class CreateController extends AbstractFOSRestController
{
    use LoggerTrait;

    /**
     * Create virtual card with given parameters
     *
     * @Annotations\Post("/")
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
     *         @SWG\Property(property="processId", type="string", description="Process id of creation"),
     *         @SWG\Property(property="activationDate", type="string", description="Virtual card's activation date", example="2020-12-11", format="YYYY-mm-dd"),
     *         @SWG\Property(property="expireDate", type="string", description="Virtual card's expiration date", example="2020-12-11", format="YYYY-mm-dd"),
     *         @SWG\Property(property="balance", type="integer"),
     *         @SWG\Property(property="currency", type="string", example="EUR", description="Currency of virtual card", pattern="^(USD|EUR)$"),
     *         @SWG\Property(property="notes", type="string", description="Extra notes to virtual card", maxLength=2048)
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Operation succeeded",
     *     @SWG\Schema(
     *          type="object",
     *          properties={
     *              @SWG\Property(property="processId", type="string"),
     *              @SWG\Property(property="reference", type="string"),
     *              @SWG\Property(property="cardNumber", type="string", maxLength=16),
     *              @SWG\Property(property="cvc", type="string", maxLength=4),
     *              @SWG\Property(property="expireDate", type="string", format="YYYY-mm-dd")
     *          }
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
     *     response="406",
     *     description="There is no matching bucket to create this virtual card",
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
     * @param VirtualCardCreateWrapper $virtualCardWrapper
     * @param FormFactoryInterface $formFactory
     * @return Response
     */
    public function indexAction(
        Request $request,
        VirtualCardCreateWrapper $virtualCardWrapper,
        FormFactoryInterface $formFactory
    ): Response {
        $form = $formFactory->create(VirtualCardType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            try {
                $result = $virtualCardWrapper->add($form->getData());

                $view = $this->view($result, Response::HTTP_CREATED);

                return $this->handleView($view);
            } catch (NoMatchingBucketException $e) {
                throw new NotAcceptableHttpException($e->getMessage(), $e);
            } catch (Throwable $e) {
                $this->logger->alert($e);

                throw new ServiceUnavailableHttpException();
            }
        }

        throw new BadRequestHttpException();
    }
}
