<?php

namespace UserBundle\Adapter\Settings;

use CoreBundle\Adapter\JsonAPIConverter;
use UserBundle\Business\Manager\SettingsManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SettingsAPIConverter
 * @package UserBundle\Adapter\Settings
 */
class SettingsAPIConverter extends JsonAPIConverter
{
    /**
     * @param SettingsManager $settingsManager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(SettingsManager $settingsManager, Request $request, $param)
    {
        parent::__construct($settingsManager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        if( $this->request->get('settingsLogo') ){
            $this->request->attributes->set($this->param, new ArrayCollection($this->manager->getSettingsLogo()));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(parent::convert()));
        }
    }
}