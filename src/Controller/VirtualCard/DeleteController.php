<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends AbstractFOSRestController
{
    /**
     * Delete virtual card with given id
     *
     * @Annotations\Delete("/virtual-card/delete/{id}", requirements={"id": "^(\d+)$"})
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
     * @return Response
     */
    public function index(Request $request): Response
    {
    
    }
}
