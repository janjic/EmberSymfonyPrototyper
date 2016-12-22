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

    const ALIAS       = 'notification';


    /**
     * Save new $notification
     * @param Notification $notification
     * @return Notification|Exception
     */
    public function saveNotification($notification)
    {
        try {
            $this->_em->persist($notification);
            $this->_em->flush();
        } catch (Exception $e) {
            throw $e;
        }

        return $notification;
    }
}