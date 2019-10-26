<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Throwable;
use VirtualCard\Exception\VirtualCard\ExpiredVirtualCardException;
use VirtualCard\Exception\VirtualCard\VirtualCardNotFoundException;
use VirtualCard\Form\RemoveVirtualCardType;
use VirtualCard\Service\VirtualCard\Remove\VirtualCardRemoveWrapper;
use VirtualCard\Traits\LoggerTrait;

class RemoveController extends AbstractFOSRestController
{
    use LoggerTrait;
    
    /**
     * Delete virtual card with given id
     *
     * @Annotations\Delete("/remove")
     *
     * @SWG\Tag(name="Virtual Card API")
     *
     * @SWG\Parameter(
     *     name="id",
     *     description="Virtual card's id",
     *     in="path",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Virtual card created successfuly",
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
     *     response="500",
     *     description="A problem(s) occurred while creating virtual card",
     *     @SWG\Schema(
     *          type="object",
     *          properties={
     *              @SWG\Property(property="message", type="string")
     *          }
     *     )
     * )
     *
     * @param Request $request
     * @param VirtualCardRemoveWrapper $virtualCardRemoveWrapper
     * @param FormFactoryInterface $formFactory
     * @return Response
     */
    public function indexAction(Request $request, VirtualCardRemoveWrapper $virtualCardRemoveWrapper, FormFactoryInterface $formFactory): Response
    {
        $form = $formFactory->create(RemoveVirtualCardType::class);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() === true && $form->isValid() === true) {
            try {
                $virtualCard = $virtualCardRemoveWrapper->check($form->get('reference')->getData());
                $result = $virtualCardRemoveWrapper->remove($virtualCard);
            
                $view = $this->view($result, 200);
            
                return $this->handleView($view);
            } catch (VirtualCardNotFoundException $e) {
                $view = $this->view([
                    'message' => $e->getMessage()
                ], 404);
    
                return $this->handleView($view);
            } catch (ExpiredVirtualCardException $e) {
                $view = $this->view([
                    'message' => $e->getMessage()
                ], 406);
    
                return $this->handleView($view);
            } catch (Throwable $e) {
                $this->logger->alert($e);
            
                throw new ServiceUnavailableHttpException(null, 'Service is currently unavailable please try again later.');
            }
        }
    
        throw new BadRequestHttpException('Your data that you sent is not valid.');
    }
}
