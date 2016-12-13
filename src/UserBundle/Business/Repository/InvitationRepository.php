<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 11.56
 */

namespace UserBundle\Business\Repository;


use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Invitation;
use Exception;

/**
 * Class InvitationRepository
 * @package UserBundle\Business\Repository
 */
class InvitationRepository extends EntityRepository
{
    const ALIAS       = 'invitation';

    /**
     * Save new invitation
     * @param Invitation $invitation
     * @return Invitation|Exception
     */
    public function saveInvitation($invitation)
    {
        try {
            $this->_em->persist($invitation);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $invitation;
    }
}