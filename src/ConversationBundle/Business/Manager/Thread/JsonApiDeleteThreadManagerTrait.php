<?php

namespace ConversationBundle\Business\Manager\Thread;

use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;

/**
 * Class JsonApiDeleteThreadManagerTrait
 * @package ConversationBundle\Business\Manager\Thread
 */
trait JsonApiDeleteThreadManagerTrait
{

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id)
    {
        // TODO: Redo logic

//        /** @var Thread $thread */
//        $thread = $this->repository->findThread($id);
//        if (sizeof($thread->getAllMetadata()) == 1)  {
//            $result = $this->repository->deleteThread($thread);
//        } else {
//            $thread->removeParticipant($this->getCurrentUser());
//            $result = $this->repository->editThread($thread);
//        }
//
//        if ($result instanceof \Exception) {
//            return AgentApiResponse::ERROR_RESPONSE($result);
//        }
//
//        return AgentApiResponse::THREAD_DELETED_SUCCESSFULLY;
    }
}