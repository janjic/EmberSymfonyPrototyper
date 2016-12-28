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
     * @param $content
     * @return ArrayCollection
     */
    public function deleteResource($content)
    {
        $content = json_decode($content);

        /** @var Agent $agent */
        $agent = $this->repository->findAgentById($content->id);
        /** @var Agent $newParent */
        $newParent = $this->repository->getEntityReference($content->newParent);

        if ($agent->getChildren()) {
            $changeParentResult = $this->repository->changeParent($agent, $newParent);
            if ($changeParentResult instanceof Exception) {
                /** error while changing parent */
                return new ArrayCollection(AgentApiResponse::AGENT_PARENT_CHANGE_ERROR_RESPONSE($changeParentResult));
            }
        }


        $syncResult = $this->syncDelete($agent);
        if ($syncResult !== true) {
            return new ArrayCollection($syncResult);
        }


        $result = $this->repository->deleteAgent($agent);
        if ($result) {
            return new ArrayCollection(AgentApiResponse::AGENT_DELETED_SUCCESSFULLY);
        } else {
            return new ArrayCollection(AgentApiResponse::AGENT_DELETE_ERROR($result));
        }
    }
}