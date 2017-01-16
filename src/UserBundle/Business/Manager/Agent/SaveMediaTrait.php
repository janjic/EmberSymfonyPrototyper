<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class SaveMediaTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait SaveMediaTrait
{

    /**
     * @param Agent $agent
     * @return bool
     */
    protected function saveMedia($agent)
    {
        /** @var Image|null $image */
        $image = $agent->getImage();
        if(!is_null($image)){
            if ($image->saveToFile($image->getBase64Content())) {
                $image->updateFileSize();
                $agent->setBaseImageUrl($image->getWebPath());

            }
            return false;
        }

        return true;

    }
}