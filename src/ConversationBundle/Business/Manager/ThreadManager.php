<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Business\Repository\ThreadRepository;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Util\Debug;
use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\Agent;
use FOS\MessageBundle\Composer\Composer as MessageComposer;
use FOS\MessageBundle\Sender\Sender as MessageSender;
use FOS\MessageBundle\Provider\Provider as MessageProvider;
use UserBundle\Entity\Document\File;

/**
 * Class ThreadManager
 * @package ConversationBundle\Business\Manager
 */
class ThreadManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;

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
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeThread($content, $mappings = null)
    {
        $relations = array('sender', 'participants');
        if (!$mappings) {
            $mappings = array(
                'thread' => array('class' => Thread::class, 'type'=>'threads'),
                'messages' => array('class' => Message::class, 'type'=>'messages'),
            );
        }

        return $this->fSerializer->setDeserializationClass(Thread::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param array $metaTags
     * @param null $mappings
     * @return mixed
     */
    public function serializeThread($content, $metaTags = [], $mappings = null)
    {
        $relations = array('messages', 'participants', 'messages.file', 'createdBy');
        if (!$mappings) {
            $mappings = array(
                'thread'       => array('class' => Thread::class, 'type'=>'threads'),
                'messages'     => array('class' => Message::class, 'type'=>'messages'),
                'file'         => array('class' => File::class, 'type'=>'files'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class),
                'createdBy'    => array('class' => Agent::class, 'type'=>'agents'),
            );
        }

        $serialize = $this->fSerializer->setDeserializationClass(Thread::class)->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getQueryResult($request)
    {
        $perPage = $request->query->get('per_page');
        $currentUser = $this->tokenStorage->getToken()->getUser();
        switch ($request->query->get('type')) {
            case 'sent':
                $threads = $this->repository->getSentThreads($currentUser, $request->query->get('page'), $perPage);
                $totalItems = $this->repository->getSentThreads($currentUser, null, null, true)[0][1];
                break;
            case 'inbox':
                $threads = $this->messageProvider->getInboxThreads();
                $totalItems = 0;
                break;
            default:
                $threads = [];
                $totalItems = 0;
                break;
        }

        return $this->serializeThread($threads, ['total_pages'=>ceil($totalItems / $perPage)]);
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
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {
        // TODO: Implement updateResource() method.
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