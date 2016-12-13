<?php

namespace ConversationBundle\Business\Repository;

use ConversationBundle\Entity\Message;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class MessageRepository
 * @package ConversationBundle\Business\Repository
 */
class MessageRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS = 'messages';

    /**
     * @param $id
     * @return mixed
     */
    public function findMessage($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);

        if (intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Save new message
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
     * Remove message
     * @param Message $message
     * @return mixed
     */
    public function removeMessage($message)
    {
        try {
            $this->_em->remove($message);
            $this->_em->flush();
        } catch (\Exception $e) {
            return $e;
        }

        return true;
    }
}