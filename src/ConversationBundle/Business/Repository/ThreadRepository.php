<?php

namespace ConversationBundle\Business\Repository;

use ConversationBundle\Entity\Message;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Class ThreadRepository
 * @package ConversationBundle\Business\Repository
 */
class ThreadRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS = 'threads';


    public function getSentThreads(ParticipantInterface $participant, $page, $offset, $isCountSearch = false)
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

        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $qb->setFirstResult(($page - 1) * $offset)->setMaxResults($offset);
        }

        return $qb->getQuery()->execute();
    }
}