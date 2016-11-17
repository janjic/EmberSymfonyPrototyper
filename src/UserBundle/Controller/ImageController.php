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


class ImageController extends Controller
{
    use JsonApiResponseTrait;

    /**
     * @Route("/api/image-save", name="api_image_save"),
     * @param ArrayCollection $imageSave
     * @return JsonResponse
     */
    public function saveImageAction(ArrayCollection $imageSave)
    {
        /**return JSON Response */
        return new JsonResponse($imageSave->toArray(), $imageSave['meta']['code']);
    }

}
