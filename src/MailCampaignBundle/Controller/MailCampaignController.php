<?php

namespace MailCampaignBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MailCampaignController extends Controller
{
    /**
     * @Route("/api/mail-campaigns/{id}", name="api_mail_campaigns", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $mailCampaignAPI
     * @return JSONResponse
     */
    public function mailCampaignAPIAction(ArrayCollection $mailCampaignAPI)
    {
        return new JSONResponse($mailCampaignAPI->toArray(), array_key_exists('errors', $mailCampaignAPI->toArray()) ? 422 : 200);
    }

    /**
     * @Route("/api/mail-templates/{id}", name="api_mail_templates", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $mailTemplateAPI
     * @return JSONResponse
     */
    public function templateAPIAction(ArrayCollection $mailTemplateAPI)
    {
        return new JSONResponse($mailTemplateAPI->toArray(), array_key_exists('errors', $mailTemplateAPI->toArray()) ? 422 : 200);
    }
}
