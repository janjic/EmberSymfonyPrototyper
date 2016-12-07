<?php

namespace UserBundle\Business\Repository;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;
use Doctrine\ORM\Query as Query;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class AgentRepository extends NestedTreeRepository
{
    const ALIAS          = 'agent';
    const ADDRESS_ALIAS  = 'address';
    const GROUP_ALIAS    = 'g';
    const ROLE_ALIAS     = 'r';
    const IMAGE_ALIAS    = 'image';
    const SUPERIOR_ALIAS = 'superior';
    const CHILDREN_ALIAS = 'children';

    /**
     * @param Agent $agent
     * @param $superior
     * @return Agent
     * @throws \Exception
     */
    public function saveAgent($agent, $superior)
    {
        try {
            if(!is_null($superior)){
                $this->persistAsFirstChildOf($agent, $superior);
            } else {
                $this->persistAsFirstChild($agent);
            }
            $this->_em->flush();
        } catch (\Exception $e) {
            throw $e;
            return new Agent();
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
        $qb->select(self::ALIAS, self::ADDRESS_ALIAS, self::IMAGE_ALIAS, self::GROUP_ALIAS, self::SUPERIOR_ALIAS, self::CHILDREN_ALIAS, self::ROLE_ALIAS);
        $qb->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS)
            ->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS)
            ->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS)
            ->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS)
            ->leftJoin(self::ALIAS.'.image', self::IMAGE_ALIAS)
            ->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);
            $user = $qb->getQuery()->getOneOrNullResult();
            return $this->loadUserRoles($user);
        } else {
            $user = $qb->getQuery()->getResult();

            return $user;
        }


    }

    /**
     * @param Agent $agent
     * @param Agent $dbSuperior
     * @param $newSuperior
     * @return Agent
     * @throws \Exception
     */
    public function edit(Agent $agent, $dbSuperior=null, $newSuperior=null)
    {
        $isHQEdit = is_null($newSuperior) && is_null($dbSuperior);

        try {
            if(!is_null($newSuperior)){
                $dbSuperior = $this->getReference($dbSuperior->getId());
                if(!is_null($dbSuperior) && in_array($newSuperior, $agent->getChildren()->getValues())){
                    $this->persistAsFirstChildOf($newSuperior, $dbSuperior);
                    $this->_em->flush();
                    $this->persistAsFirstChildOf($agent, $newSuperior);
                } else {

                    $this->persistAsFirstChildOf($agent, $newSuperior);
                }
            } else {
                $isHQEdit? $this->_em->merge($agent):$this->persistAsFirstChild($agent);
            }
            $this->_em->flush();
        } catch (\Exception $e) {
            throw $e;
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

    /**
     * @param mixed $page
     * @param mixed $offset
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @return array
     */
    public function findAllForJQGRID($page, $offset, $sortParams, $additionalParams)
    {
        $firstResult =0;
        if ($page !=1) {
            $firstResult = ($page-1)*$offset;
            // $offset = $page*$offset;
        }
        $qb= $this->createQueryBuilder(self::ALIAS);
        if (array_key_exists('search_param', $additionalParams)) {
            $qb->andWhere($qb->expr()->like(self::ALIAS.'.username', $qb->expr()->literal('%'.$additionalParams['search_param'].'%')));;
        }
        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy($sortParams[0], $sortParams[1]);
        return $qb->getQuery()->getResult();
    }
    /**
     * @param mixed $searchParams
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @param bool  $isCountSearch
     * @return array
     */
    public function searchForJQGRID($searchParams, $sortParams, $additionalParams, $isCountSearch = false)
    {
        $oQ0= $this->createQueryBuilder(self::ALIAS);

        $firstResult = 0;
        $offset = 0;
        if ($searchParams) {
            if ($searchParams[0]['toolbar_search']) {
                $page = $searchParams[0]['page'];
                $offset = $searchParams[0]['rows'];
                $firstResult = 0;
                if ($page != 1) {
                    $firstResult = ($page - 1) * $offset;
                    $offset = $page * $offset;
                }
                array_shift($searchParams);
                foreach ($searchParams[0] as $key => $param) {
                    if ($key == 'agent.enabled') {
                        if ($param != -1) {
                            $oQ0->andWhere('agent.enabled = '.$param);
                        }
                    } else if($key == 'address.country'){
                        $oQ0->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS);
                        $oQ0->andWhere($oQ0->expr()->like(self::ADDRESS_ALIAS.'.country', $oQ0->expr()->literal('%'.$param.'%')));
                    }  else if($key == 'group.name'){
                        $oQ0->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);
                        $oQ0->andWhere(self::GROUP_ALIAS.'.id = '.$param);
                    }
                    else {
                        $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%'.$param.'%')));
                    }
                }
            } else {
                $searchParams = $searchParams[1];
                $searchField = $searchParams['searchField'];
                $searchString = $searchParams['searchString'];
                $searchOperator = $searchParams['searchOper'];
                $page = $searchParams['page'];
                $offset = $searchParams['rows'];
                $firstResult = 0;
                if ($page != 1) {
                    $firstResult = ($page - 1) * $offset;
                    $offset = $page * $offset;
                }
                //numeric fields
                if (is_numeric($searchString)) {
                    switch ($searchOperator) {
                        case 'eq':
                            $oQ0->andWhere($oQ0->expr()->eq($searchField, $searchString));
                            break;
                        case 'ne':
                            $oQ0->andWhere(
                                $oQ0->expr()->not($oQ0->expr()->eq($searchField, $searchString))
                            );
                            break;
                        case 'nu':
                            $oQ0->andWhere($oQ0->expr()->isNull($searchField));
                            break;
                        case 'nn':
                            $oQ0->andWhere($oQ0->expr()->not($oQ0->expr()->isNull($searchField)));
                            break;
                    }
                }
                //text fields
                if (!is_numeric($searchString)) {
                    switch ($searchOperator) {
                        case 'eq':
                            $oQ0->andWhere(
                                $oQ0->expr()->eq($searchField, $oQ0->expr()->literal($searchString))
                            );
                            break;
                        case 'ne':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->eq($searchField, $oQ0->expr()->literal($searchString))
                                )
                            );
                            break;
                        case 'bw':
                            $oQ0->andWhere(
                                $oQ0->expr()->like($searchField, $oQ0->expr()->literal($searchString.'%'))
                            );
                            break;
                        case 'bn':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $searchField,
                                        $oQ0->expr()->literal($searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'ew':
                            $oQ0->andWhere(
                                $oQ0->expr()->like($this->getAlias().'.'.$searchField, $oQ0->expr()->literal('%'.$searchString))
                            );
                            break;
                        case 'en':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $this->getAlias().'.'.$searchField,
                                        $oQ0->expr()->literal($searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'cn':
                            $oQ0->andWhere(
                                $oQ0->expr()->like(
                                    $searchField,
                                    $oQ0->expr()->literal('%'.$searchString.'%')
                                )
                            );
                            break;
                        case 'nc':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $searchField,
                                        $oQ0->expr()->literal('%'.$searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'nu':
                            $oQ0->andWhere($oQ0->expr()->isNull($searchField));
                            break;
                        case 'nn':
                            $oQ0->andWhere($oQ0->expr()->not($oQ0->expr()->isNull($searchField)));
                            break;
                    }
                }
            }
        }
        if ($isCountSearch) {
            $oQ0->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $oQ0->setFirstResult($firstResult)->setMaxResults($offset);
        }
        if ($sortParams) {
            $oQ0->orderBy($sortParams[0], $sortParams[1]);
        }
        return $oQ0->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     */
    public function getReference($id)
    {
        $className = $this->getClassMetadata()->getReflectionClass()->getName();

        return $this->_em->getReference($className, $id);
    }

    /**
     * @return array
     */
    public function loadRootAndChildren()
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS.'.id', 'CONCAT('.self::ALIAS.'.firstName'.', \' \', '.self::ALIAS.'.lastName'.') AS name',
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount',  self::ALIAS.'.email', self::SUPERIOR_ALIAS.'.id as superior_id');
        $qb->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        $qb->where(self::SUPERIOR_ALIAS.'.superior is NULL');
        $qb->orWhere(self::ALIAS.'.superior is NULL');

        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $parent
     * @return array
     */
    public function loadChildren($parent)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS.'.id', 'CONCAT('.self::ALIAS.'.firstName'.', \' \', '.self::ALIAS.'.lastName'.') AS name',
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount', self::ALIAS.'.email');
        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        $qb->where(self::ALIAS.'.superior =?1');
        $qb->setParameter(1, $parent);

        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }
}