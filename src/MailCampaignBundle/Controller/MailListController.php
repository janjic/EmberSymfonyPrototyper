<?php

namespace MailCampaignBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MailListController extends Controller
{
    /**
     * @Route("/api/mail-lists/{id}", name="api_mail_list", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $mailListAPI
     * @return JSONResponse
     */
    public function mailListAPIAction(ArrayCollection $mailListAPI)
    {
        return new JSONResponse($mailListAPI->toArray(), array_key_exists('errors', $mailListAPI->toArray()) ? 422 : 200);
    }
}
