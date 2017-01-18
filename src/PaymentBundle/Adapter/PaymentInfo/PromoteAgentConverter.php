<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class PromoteAgentConverter
 * @package UserBundle\Adapter\Agent
 */
class PromoteAgentConverter extends JsonAPIConverter
{
    /**
     * @param PaymentInfoManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(PaymentInfoManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        if($this->request->getMethod() == 'GET'){
            $this->request->attributes->set($this->param, new ArrayCollection($this->manager->getPromotionSuggestions(null)));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection($this->manager->getPromotionSuggestions($this->request->request)));
        }

    }

}