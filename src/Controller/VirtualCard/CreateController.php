<?php

namespace VirtualCard\Controller\VirtualCard;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends AbstractFOSRestController
{
    /**
     * Create virtual card with given parameters
     *
     * @Annotations\Put("/virtual-card/add")
     *
     * @SWG\Tag(name="Virtual Card API")
     *
     * @SWG\Parameter(
     *     name="processId",
     *     description="Process id of creation",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     *
     * @SWG\Parameter(
     *     name="activationDate",
     *     description="Virtual card's activation date",
     *     in="body",
     *     type="string",
     *     required=true,
     *     format="YYYY-mm-dd",
     *     @SWG\Schema(type="string")
     * )
     *
     * @SWG\Parameter(
     *     name="expireDate",
     *     description="Virtual card's expiration date",
     *     in="body",
     *     type="string",
     *     required=true,
     *     format="YYYY-mm-dd",
     *     @SWG\Schema(type="string")
     * )
     *
     * @SWG\Parameter(
     *     name="balance",
     *     description="Virtual card's requested balance. Amount must be send in penny",
     *     in="body",
     *     type="integer",
     *     required=true,
     *     @SWG\Schema(type="integer")
     * )
     *
     * @SWG\Parameter(
     *     name="currency",
     *     description="Currency of virtual card",
     *     in="body",
     *     type="string",
     *     required=true,
     *     maxLength=4,
     *     pattern="^(USD|EUR)$",
     *     @SWG\Schema(type="string")
     * )
     *
     * @SWG\Parameter(
     *     name="notes",
     *     description="Extra notes to virtual card",
     *     in="body",
     *     type="string",
     *     required=false,
     *     maxLength=2048,
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
