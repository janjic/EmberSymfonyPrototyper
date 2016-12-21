<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Thread\JsonApiThreadSerializationTrait;
use ConversationBundle\Business\Manager\Thread\JsonApiUpdateThreadManagerTrait;
use ConversationBundle\Business\Repository\ThreadRepository;
use ConversationBundle\Entity\Thread;
use ConversationBundle\Entity\ThreadMetadata;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use FOS\MessageBundle\Provider\Provider as MessageProvider;

/**
 * Class ThreadManager
 * @package ConversationBundle\Business\Manager
 */
class ThreadManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiUpdateThreadManagerTrait;
    use JsonApiThreadSerializationTrait;

    /**
     * @var ThreadRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var MessageProvider $messageProvider
     */
    protected $messageProvider;

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    protected $tokenStorage;

    /**
     * @param ThreadRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param MessageProvider $messageProvider
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(ThreadRepository $repository, FJsonApiSerializer $fSerializer,
                                MessageProvider $messageProvider, TokenStorageInterface $tokenStorage)
    {
        $this->repository       = $repository;
        $this->fSerializer      = $fSerializer;
        $this->messageProvider  = $messageProvider;
        $this->tokenStorage     = $tokenStorage;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getQueryResult($request)
    {
        $perPage = $request->query->get('per_page');
        $currentUser = $this->getCurrentUser();
        switch ($request->query->get('type')) {
            case 'sent':
                $threads = $this->repository->getSentThreads($currentUser, $request->query->get('page'), $perPage);
                $totalItems = $this->repository->getSentThreads($currentUser, null, null, true)[0][1];
                break;
            case 'received':
                $threads = $this->repository->getInboxThreads($currentUser, $request->query->get('page'), $perPage);
                $totalItems = $this->repository->getInboxThreads($currentUser, null, null, true)[0][1];
                break;
            case 'deleted':
                $threads = $this->repository->getDeletedThreads($currentUser, $request->query->get('page'), $perPage);
                $totalItems = $this->repository->getDeletedThreads($currentUser, null, null, true)[0][1];
                break;
            default:
                $threads = [];
                $totalItems = 0;
                break;
        }

        $user = $this->getCurrentUser();
        /** @var Thread $thread */
        foreach ($threads as $thread) {
            $thread->setIsRead($thread->isReadByParticipantCustom($user));
        }

        return $this->serializeThread($threads, ['total_pages'=>ceil($totalItems / $perPage)]);
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * @param Thread $thread
     * @return Thread|\Exception
     */
    public function setAsRead(Thread $thread)
    {
        $user = $this->getCurrentUser();
        /** @var ThreadMetadata $meta */
        foreach ($thread->getAllMetadata() as $meta) {
            if ($meta->getParticipant()->getId() == $user->getId()) {
                $meta->setIsReadByParticipant(true);
            }
        }

        return $this->repository->editThread($thread);
    }

    /**
     * @param ParticipantInterface $participant
     * @return array
     */
    public function getNumberOfUnread(ParticipantInterface $participant)
    {
        return $this->repository->getNumberOfUnread($participant);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        // TODO: Implement getResource() method.
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveResource($data)
    {
        // TODO: Implement saveResource() method.
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }
}