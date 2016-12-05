<?php

namespace UserBundle\Controller;

use CoreBundle\Business\Serializer\FSDSerializer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use UserBundle\Business\Schema\Agent\AgentSimpleSchema;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\TCRUser;

class TCRUserController extends Controller
{
    /**
     * @Route("/api/tcr-users/{id}", name="api_tcr_users", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $tCRUserAPI
     * @return Response
     */
    public function tcrUsersAPIAction(ArrayCollection $tCRUserAPI)
    {
        $status = array_key_exists(1, $tCRUserAPI->toArray()) ? $tCRUserAPI[1] : 200;

        return new JsonResponse($tCRUserAPI[0], $status);
    }
}
