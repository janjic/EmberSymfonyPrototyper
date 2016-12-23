<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 21.12.16.
 * Time: 14.19
 */

namespace UserBundle\Business\Repository;


use Exception;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
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
     * @param bool $isCountSearch
     * @param int  $user_id
     * @return array|mixed
     */
    public function getNotificationsForInfinityScroll($user_id, $page = 1 , $offset = 10, $minId = null, $maxId = null, $isCountSearch = false)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);

        $qb->orderBy(self::ALIAS.'.id', 'DESC');

        $qb->where('agent.id = :id')->setParameter('id', $user_id);

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