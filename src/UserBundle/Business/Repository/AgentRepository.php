<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class AgentRepository extends EntityRepository
{
    const ALIAS          = 'agent';
    const ADDRESS_ALIAS  = 'address';
    const GROUP_ALIAS    = 'g';
    const ROLE_ALIAS     = 'r';
    const IMAGE_ALIAS    = 'image';
    const SUPERIOR_ALIAS = 'superior';

    /**
     * @param $agent
     * @return Agent
     * @throws \Exception
     */
    public function saveAgent($agent)
    {
        try {
            $this->_em->persist($agent);
            $this->_em->flush();
        } catch (\Exception $e) {
            throw $e;
        }

        return $agent;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findAgentById($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::ADDRESS_ALIAS, self::IMAGE_ALIAS, self::GROUP_ALIAS, self::SUPERIOR_ALIAS, self::ROLE_ALIAS);
        $qb->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS)
        ->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS)
        ->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS)
        ->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS)
        ->leftJoin(self::ALIAS.'.image', self::IMAGE_ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);
            $user = $qb->getQuery()->getOneOrNullResult();
        } else {
            $user = $qb->getQuery()->getResult();
        }

        return $this->loadUserRoles($user);
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function edit(Agent $agent)
    {
        try {
            $this->_em->merge($agent);
            $this->_em->flush();
        } catch (\Exception $e) {

            return new Agent();
        }

        return $agent;
    }


    /**
     * @param $usernameOrEmail
     * @return mixed
     */
    public function getUserForProvider($usernameOrEmail)
    {
        $q = $this
            ->createQueryBuilder('a')
            ->select(array('a', 'g', 'r'))
            ->leftJoin('a.group', 'g')
            ->leftJoin('g.roles', 'r')
            ->where('a.username = :username OR a.email = :email')
            ->andWhere('a.enabled = 1')
            ->setParameter('username', $usernameOrEmail)
            ->setParameter('email', $usernameOrEmail)
            ->getQuery();
        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            /** @var Agent $user */
            $user = $q
                ->getSingleResult();

            return $this->loadUserRoles($user);

        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active user identified by "%s".',
                $usernameOrEmail
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

    }

    /**
     * @param $class
     * @return bool
     */
    public function isClassSupportedForProvider($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {

        $class = get_class($user);
        if (!$this->isClassSupportedForProvider($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        $q= $this
            ->createQueryBuilder('a')
            ->select(array('a', 'g', 'r'))
            ->leftJoin('a.group', 'g')
            ->leftJoin('g.roles', 'r')
            ->where('u.id = :id')
            ->setParameter('id', $user->getId())
            ->getQuery();
        /** @var Agent $user */
        $user = $q
            ->getSingleResult();

        return $this->loadUserRoles($user);
    }

    /**
     * @param Agent $user
     * @return Agent
     */
    private function loadUserRoles(Agent $user)
    {
        $roles = array();

        if (($group = $user->getGroup()) instanceof Group) {
            foreach ($group->getRoles() as $role) {
                $roles[] = ($role instanceof RoleInterface ? $role->getRole() : (string) $role);
                $childrenRoles =  $this->_em->getRepository('UserBundle:Role')->children($role);
                foreach ($childrenRoles as $childrenRole) {
                    $roles[] = ($childrenRole instanceof RoleInterface ? $childrenRole->getRole() : (string) $childrenRole);
                }
            }
        }
        $roles = array_unique($roles);
        $user->setRoles($roles);

        return $user;

    }
}