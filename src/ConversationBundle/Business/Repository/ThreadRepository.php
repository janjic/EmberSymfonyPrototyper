<?php

namespace ConversationBundle\Business\Repository;

use ConversationBundle\Entity\Thread;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Class ThreadRepository
 * @package ConversationBundle\Business\Repository
 */
class ThreadRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS = 'threads';

    /**
     * @param ParticipantInterface $participant
     * @param int                  $page
     * @param int                  $offset
     * @param bool                 $isCountSearch
     * @return mixed
     */
    public function getSentThreads(ParticipantInterface $participant, $page = 1, $offset = 20, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS)
            ->innerJoin(self::ALIAS.'.metadata', 'tm')
            ->innerJoin('tm.participant', 'p')

            // the participant is in the thread participants
            ->andWhere('p.id = :user_id')
            ->setParameter('user_id', $participant->getId())

            // the thread does not contain spam or flood
            ->andWhere(self::ALIAS.'.isSpam = :isSpam')
            ->setParameter('isSpam', false, \PDO::PARAM_BOOL)

            // the thread is not deleted by this participant
            ->andWhere('tm.isDeleted = :isDeleted')
            ->setParameter('isDeleted', false, \PDO::PARAM_BOOL)

            // there is at least one message written by this participant
            ->andWhere('tm.lastParticipantMessageDate IS NOT NULL')

            // sort by date of last message written by this participant
            ->orderBy('tm.lastParticipantMessageDate', 'DESC');

        $qb->leftJoin(self::ALIAS.'.ticket', 'ticket');
        $qb->andWhere('ticket.id IS NULL');

        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $qb->setFirstResult(($page - 1) * $offset)->setMaxResults($offset);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param ParticipantInterface $participant
     * @param int                  $page
     * @param int                  $offset
     * @param bool                 $isCountSearch
     * @return mixed
     */
    public function getInboxThreads(ParticipantInterface $participant, $page = 1 , $offset = 20, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS)
            ->innerJoin(self::ALIAS.'.metadata', 'tm')
            ->innerJoin('tm.participant', 'p')

            // the participant is in the thread participants
            ->andWhere('p.id = :user_id')
            ->setParameter('user_id', $participant->getId())

            // the thread does not contain spam or flood
            ->andWhere(self::ALIAS.'.isSpam = :isSpam')
            ->setParameter('isSpam', false, \PDO::PARAM_BOOL)

            // the thread is not deleted by this participant
            ->andWhere('tm.isDeleted = :isDeleted')
            ->setParameter('isDeleted', false, \PDO::PARAM_BOOL)

            // there is at least one message written by an other participant
            ->andWhere('tm.lastMessageDate IS NOT NULL')

            // sort by date of last message written by an other participant
            ->orderBy('tm.lastMessageDate', 'DESC');

        $qb->leftJoin(self::ALIAS.'.ticket', 'ticket');
        $qb->andWhere('ticket.id IS NULL');

        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $qb->setFirstResult(($page - 1) * $offset)->setMaxResults($offset);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param ParticipantInterface $participant
     * @param int                  $page
     * @param int                  $offset
     * @param bool                 $isCountSearch
     * @return mixed
     */
    public function getDeletedThreads(ParticipantInterface $participant, $page = 1 , $offset = 20, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS)
            ->innerJoin(self::ALIAS.'.metadata', 'tm')
            ->innerJoin('tm.participant', 'p')

            // the participant is in the thread participants
            ->andWhere('p.id = :user_id')
            ->setParameter('user_id', $participant->getId())

            // the thread is deleted by this participant
            ->andWhere('tm.isDeleted = :isDeleted')
            ->setParameter('isDeleted', true, \PDO::PARAM_BOOL)

            // sort by date of last message
            ->orderBy('tm.lastMessageDate', 'DESC');

        $qb->leftJoin(self::ALIAS.'.ticket', 'ticket');
        $qb->andWhere('ticket.id IS NULL');

        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $qb->setFirstResult(($page - 1) * $offset)->setMaxResults($offset);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param Thread $thread
     * @return Thread|Exception
     */
    public function editThread($thread)
    {
        try {
            $this->_em->merge($thread);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $thread;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findThread($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, 'meta');
        $qb->leftJoin(self::ALIAS.'.metadata', 'meta');
        $qb->where(self::ALIAS.'.id =:id')->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param ParticipantInterface $participant
     * @return array
     */
    public function getNumberOfUnread(ParticipantInterface $participant)
    {
        $qb = $this->createQueryBuilder(self::ALIAS)
            ->innerJoin(self::ALIAS.'.metadata', 'tm')
            ->innerJoin('tm.participant', 'p')

            // the participant is in the thread participants
            ->andWhere('p.id = :user_id')
            ->setParameter('user_id', $participant->getId())

            // the thread is not deleted by this participant
            ->andWhere('tm.isReadByParticipant = :isRead')
            ->setParameter('isRead', false);

        $qb->select('COUNT(DISTINCT '.self::ALIAS.')');

        $qb->leftJoin(self::ALIAS.'.ticket', 'ticket');
        $qb->andWhere('ticket.id IS NULL');

        return $qb->getQuery()->getResult();
    }
}