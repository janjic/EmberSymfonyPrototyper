<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use NilPortugues\Api\JsonApi\Http\Request\Parameters\Fields;
use NilPortugues\Symfony\JsonApiBundle\Serializer\JsonApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AddressController extends Controller
{

    use JsonApiResponseTrait;

    /**
     * @Route("/api/address-save", name="api_address_save"),
     * @param ArrayCollection $addressSave
     * @return JsonResponse
     */
    public function saveAddressAction(ArrayCollection $addressSave)
    {
        /**return JSON Response */
        return new JsonResponse($addressSave->toArray(), $addressSave['meta']['code']);
    }

}
