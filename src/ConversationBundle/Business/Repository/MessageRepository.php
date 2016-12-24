<?php

namespace ConversationBundle\Business\Repository;

use ConversationBundle\Entity\Message;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;
use FOS\MessageBundle\Model\MessageInterface;

/**
 * Class MessageRepository
 * @package ConversationBundle\Business\Repository
 */
class MessageRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS = 'messages';

    /**
     * @param Message $message
     * @return Message|Exception
     */
    public function saveMessage($message)
    {
        try {
            $this->_em->persist($message);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $message;
    }

    /**
     * @param Message $message
     * @return Message|Exception
     */
    public function editMessage($message)
    {
        try {
            $this->_em->merge($message);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $message;
    }

    /**
     * @param int  $threadId
     * @param int  $page
     * @param int  $offset
     * @param null $minId
     * @param null $maxId
     * @param bool $isCountSearch
     * @return array|mixed
     */
    public function getMessagesForThread($threadId, $page = 1 , $offset = 10, $minId = null, $maxId = null, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.thread', 'thread');

        $qb->orderBy(self::ALIAS.'.id', 'DESC');

        $qb->where('thread.id =:id')->setParameter('id', $threadId);
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

}
