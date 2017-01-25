<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Locale;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Util\CountryCodesUtil;

/**
 * Class AgentsByCountryConverter
 * @package UserBundle\Adapter\Agent
 */
class AgentsByCountryConverter extends BasicConverter
{

    /**
     * @param AgentManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(AgentManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {

       $data = $this->manager->findAgentsByCountry();

       foreach ($data as &$item) {
           if($item['nationality'] == 'ENGLAND'){
               $item['nationality'] = 'UNITED KINGDOM';
           }
           $item['countryFlagCode'] = CountryCodesUtil::getTwoDigitFromFullName($item['nationality']);
           $item['countryIsoCode'] = CountryCodesUtil::getThreeDigitFromTwoDigitCode($item['countryFlagCode']);
       }

        $this->request->attributes->set($this->param, new ArrayCollection($data));
    }

}