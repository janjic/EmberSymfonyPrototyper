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
 * Class JsonApiDeleteAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiDeleteAgentManagerTrait
{

    /**
     * {@inheritdoc}
     */
    public function deleteResource($id = null)
    {
        // TODO: Implement deleteResource() method.
    }
}