<?php

namespace UserBundle\Controller;

use CoreBundle\Model\XmppPrebind;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class TCRUserController extends Controller
{
    /**
     * @Route("/test", name="test", defaults={"user_param": "all"}),
     * @return JsonResponse
     */
    public function testAction()
    {


        die('kraj');
        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }
}