<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiDeleteAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiDeleteAgentManagerTrait
{

    /**
     * @param Request $request
     */
    public function deleteResource($request)
    {
        var_dump($request);die();
        // TODO: Implement deleteResource() method.
    }
}