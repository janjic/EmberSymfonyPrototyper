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
     */
    public function deleteResource($content)
    {
        $content = json_decode($content);

        /** @var Agent $agent */
        $agent = $this->repository->findAgentById($content->id);
        /** @var Agent $newParent */
        $newParent = $this->repository->getEntityReference($content->newParent);

        if ($agent->getChildren()) {
            $changeParentResult = $this->repository->changeParent($agent, $newParent, false);
            if (!$changeParentResult) {
                // vrati da je doslo do greske prolikom promene roditelja
            }
        }

        $result =  $this->repository->deleteAgent($agent, false);

        if ($result) {
            $this->repository->flushDb();

        }

        var_dump($result);die();
        // TODO: Implement deleteResource() method.
    }
}