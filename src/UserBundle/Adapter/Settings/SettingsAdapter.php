<?php

namespace UserBundle\Adapter\Settings;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\SettingsManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SettingsAdapter
 * @package UserBundle\Adapter\Settings
 */
class SettingsAdapter extends BaseAdapter
{
    /**
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager= $settingsManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).InvitationAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->SettingsManager, $request, $param);
    }
}