<?php

namespace ConversationBundle\Business\Manager\Thread;

use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;

/**
 * Class JsonApiUpdateThreadManagerTrait
 * @package ConversationBundle\Business\Manager\Thread
 */
trait JsonApiUpdateThreadManagerTrait
{

    /**
     * @param string $data
     * @return mixed
     */
    public function updateResource($data)
    {
        /** @var Thread $thread */
        $thread = $this->deserializeThread($data);
        /** @var Thread $threadDB */
        $threadDB = $this->repository->findThread($thread->getId());
        if ($thread->isToBeDeleted()) {
            $threadDB->setIsDeletedByParticipant($this->getCurrentUser(), true);
        }

        $result = $this->repository->editThread($threadDB);

        return $this->createJsonAPiUpdateResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiUpdateResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Thread::class && ($id = $data->getId())):
                return AgentApiResponse::THREAD_EDITED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}