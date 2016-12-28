<?php

namespace UserBundle\Business\Repository;


use ConversationBundle\Entity\Thread;
use Exception;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Notification;

/**
 * Class NotificationRepository
 * @package UserBundle\Business\Repository
 */
class NotificationRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS             = 'notification';
    const AGENT_ALIAS       = 'agent';
    const NEW_AGENT_ALIAS   = 'new_agent';
    const MESSAGE_ALIAS     = 'message';
    const THREAD_ALIAS      = 'thread';

    /**
     * Save new $notification
     * @param array $notifications
     * @return boolean
     * @throws Exception
     */
    public function saveNotification($notifications)
    {
        try {
            foreach ($notifications as $notification) {
                $this->_em->persist($notification);
            }
            $this->_em->flush();
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * @param int  $page
     * @param int  $offset
     * @param null $minId
     * @param null $maxId
     * @param string $type
     * @param bool $isCountSearch
     * @param int  $user_id
     * @return array|mixed
     */
    public function getNotificationsForInfinityScroll($user_id, $page = 1 , $offset = 10, $minId = null, $maxId = null, $type = "", $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::ALIAS.'.newAgent', self::NEW_AGENT_ALIAS);

        $qb->orderBy(self::ALIAS.'.id', 'DESC');

        $qb->where('agent.id = :id')->setParameter('id', $user_id);
        $qb->andWhere(self::ALIAS.'.type LIKE :type')->setParameter('type', '%'.$type.'%');

        if ($minId) {
            $qb->andWhere(self::ALIAS . '.id < ?2')->setParameter(2, $minId);
            $qb->setMaxResults($offset);
        } else if ($maxId) {
            $qb->andWhere(self::ALIAS . '.id > ?3')->setParameter(3, $maxId);
        } else if (!$isCountSearch){
            $qb->setFirstResult(($page - 1) * $offset);
            $qb->setMaxResults($offset);
        }

        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id)');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Notification $notification
     * @return Notification|Exception
     */
    public function editNotification($notification)
    {
        try {
            $this->_em->merge($notification);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $notification;
    }

    /**
     * @param Thread $thread
     * @param Agent $user
     */
    public function updateNotificationsToSeen($thread, $user)
    {
        $thread_id = $thread->getId();
        $user_id   = $user->getId();

//        $qb = $this->createQueryBuilder(self::ALIAS);
//        $qb->select(self::ALIAS);
//        $qb->leftJoin(self::ALIAS.'.message', self::MESSAGE_ALIAS);
//        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
//        $qb->leftJoin(self::MESSAGE_ALIAS.'.thread', self::THREAD_ALIAS);
//
//        $qb->where(self::THREAD_ALIAS.'.id = :thread_id')->setParameter('thread_id', $thread_id);
//        $qb->andWhere('agent.id = :agent_id')->setParameter('agent_id', $user_id);
//        $qb->andWhere(self::ALIAS.'.isSeen = ?1')->setParameter(1, false);
//
//        var_dump($qb->getQuery()->getSQL());
//        var_dump($qb->getQuery()->getParameters());
//        var_dump($qb->getQuery()->getResult());
//        die();

        if( !$thread->isReadByParticipantCustom($user) ) {
            try {
                $sql = "UPDATE as_notification, as_message, as_agent, as_thread ";
                $sql .= "SET `is_seen`= 1 WHERE as_notification.message_id = as_message.id AND as_message.thread_id = as_thread.id ";
                $sql .= "AND as_notification.agent_id = as_agent.id AND as_thread.id = " . $thread_id . " AND as_agent.id=" . $user_id;

                $stmt = $this->_em->getConnection()->prepare($sql);
                $stmt->execute();
            } catch (Exception $ex) {
            }
        }
    }
}