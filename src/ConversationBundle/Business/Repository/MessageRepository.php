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
     * @param int  $threadId
     * @param int  $page
     * @param int  $offset
     * @param null $minId
     * @param bool $isCountSearch
     * @return array|mixed
     */
    public function getMessagesForThread($threadId, $page = 1 , $offset = 10, $minId = null, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.thread', 'thread');

        $qb->orderBy(self::ALIAS.'.id', 'DESC');

        $qb->where('thread.id =:id')->setParameter('id', $threadId);
        $qb->andWhere(self::ALIAS.'id < ?2')->setParameter(2, $minId);
        if ($isCountSearch) {
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id)');
        } else {
            $qb->setFirstResult(($page - 1) * $offset)->setMaxResults($offset);
        }

        return $qb->getQuery()->getResult();
    }

}