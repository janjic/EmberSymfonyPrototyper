<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Types\Type;
use Exception;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
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
class AgentRepository extends NestedTreeRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS              = 'agent';
    const ADDRESS_ALIAS      = 'address';
    const GROUP_ALIAS        = 'g';
    const ROLE_ALIAS         = 'r';
    const IMAGE_ALIAS        = 'image';
    const SUPERIOR_ALIAS     = 'superior';
    const CHILDREN_ALIAS     = 'children';
    const AGENT_TABLE_NAME   = 'as_agent';
    const SUPERIOR_ATTRIBUTE = 'superior';

    /**
     * @param Agent $agent
     * @param $superior
     * @return Agent|Exception
     * @throws \Exception
     */
    public function saveAgent($agent, $superior=null)
    {
        try {
            $agent ? ($agent = $this->loadUserRoles($agent)) :false;
            if(!is_null($superior)){
                $this->persistAsFirstChildOf($agent, $superior);
            } else {
                $this->persistAsFirstChild($agent);
            }
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $e;
        } catch (Exception $e) {
            throw  $e;
            return $e;
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
//        $qb->setFirstResult(1);
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
     * @return Agent|Exception
     * @throws \Exception
     */
    public function edit(Agent $agent, $dbSuperior=null, $newSuperior=null)
    {
        $isHQEdit = is_null($newSuperior) && is_null($dbSuperior);
        $agent = $this->loadUserRoles($agent);
        try {
            if(!is_null($newSuperior)){
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
//            $this->_em->flush();
        } catch (\Exception $e) {
            return $e;
        }

        return $agent;
    }

    public function flushDb()
    {
        $this->_em->flush();
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

            return $user;
            //return $this->loadUserRoles($user);

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
     * @param mixed $promoCode
     * @return array
     */
    public function findAllForJQGRID($page, $offset, $sortParams, $additionalParams, $promoCode = false)
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
        if ( $promoCode ) {
            $qb->leftJoin(self::ALIAS.'.'.self::SUPERIOR_ALIAS, self::SUPERIOR_ALIAS);
            $qb->andWhere(self::SUPERIOR_ALIAS.'.agentId = :agentCode')->setParameter('agentCode', $promoCode);
        }
        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy($sortParams[0], $sortParams[1]);
        return $qb->getQuery()->getResult();
    }
    /**
     * @param mixed $searchParams
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @param bool  $isCountSearch
     * @param mixed $promoCode
     * @return array
     */
    public function searchForJQGRID($searchParams, $sortParams, $additionalParams, $isCountSearch = false, $promoCode= false)
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
                }
                array_shift($searchParams);

                foreach ($searchParams[0] as $key => $param) {
                    if ($key == 'agent.enabled') {
                        if ($param != -1) {
                            if ($additionalParams && array_key_exists('or', $additionalParams) && $additionalParams['or']) {
                                $oQ0->orWhere('agent.enabled = '.$param);
                            } else {
                                $oQ0->andWhere('agent.enabled = '.$param);
                            }

                        }
                    } else if($key == 'address.country'){
                        $oQ0->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS);
                        if ($additionalParams && array_key_exists('or', $additionalParams) && $additionalParams['or']) {
                            $oQ0->orWhere($oQ0->expr()->like(self::ADDRESS_ALIAS.'.country', $oQ0->expr()->literal('%'.$param.'%')));
                        } else {
                            $oQ0->andWhere($oQ0->expr()->like(self::ADDRESS_ALIAS.'.country', $oQ0->expr()->literal('%'.$param.'%')));
                        }
                    }  else if($key == 'group.name'){
                        $oQ0->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);
                        if ($additionalParams && array_key_exists('or', $additionalParams) && $additionalParams['or']) {
                            $oQ0->orWhere(self::GROUP_ALIAS.'.id = '.$param);
                        } else {
                            $oQ0->andWhere(self::GROUP_ALIAS.'.id = '.$param);
                        }

                    }
                    else {
                        if ($additionalParams && array_key_exists('or', $additionalParams) && $additionalParams['or']) {
                            $oQ0->orWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%' . $param . '%')));
                        } else {
                            $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%' . $param . '%')));
                        }
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
        if( $promoCode ){
            $oQ0->leftJoin(self::ALIAS.'.'.self::SUPERIOR_ALIAS, self::SUPERIOR_ALIAS);
            $oQ0->andWhere(self::SUPERIOR_ALIAS.'.agentId = :agentCode')->setParameter('agentCode', $promoCode);
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
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount',  self::ALIAS.'.email', self::SUPERIOR_ALIAS.'.id as superior_id',
            self::ALIAS.'.baseImageUrl', self::GROUP_ALIAS.'.name AS groupName');
        $qb->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);

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
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount', self::ALIAS.'.email', self::GROUP_ALIAS.'.name AS groupName');

        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);
        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);

        $qb->where(self::ALIAS.'.superior =?1');
        $qb->setParameter(1, $parent);

        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Agent $oldParent
     * @param Agent $newParent
     * @return bool|Exception
     */
    public function changeParent($oldParent, $newParent)
    {
        try {

            foreach ($oldParent->getChildren() as $agent) {
                $this->persistAsFirstChildOf($agent, $newParent);
            }

        } catch (\Exception $e) {
            return $e;
        }

        return true;
    }

    /**
     * @param Agent $agent
     * @return bool|Exception
     */
    public function deleteAgent($agent)
    {
        $connection = $this->_em->getConnection();
        $connection->beginTransaction();
        try {
            $this->flushDb();

            $this->removeFromTree($agent);

            $this->flushDb();

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            return $e;
        }

        return true;
    }


    /**
     * @param $roleName
     * @return Agent|null
     */
    public function findAgentByRole($roleName = "ROLE_SUPER_ADMIN")
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS)
            ->where($qb->expr()->like(self::ALIAS.'.roles', '\'%ROLE_SUPER_ADMIN%\''));

        return $qb->getQuery()->getOneOrNullResult();
    }


    /**
     * @return array
     */
    public function findAgentsByCountry()
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(agent.id) as agentsNumb', self::ALIAS.'.nationality')
            ->groupBy(self::ALIAS.'.nationality')
            ->orderBy('agentsNumb', 'desc');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $agent
     * @param $period
     *
     * @return int
     */
    public function newAgentsCount($agent, $period)
    {
        switch ($period){
            case 'today': $date = new \DateTime('-1 day');break;
            case 'month': $date = new \DateTime('-1 month');break;
            default: $date = null;
        }

        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select($qb->expr()->count(self::ALIAS.'.id'));
        $qb->where($qb->expr()->isNotNull(self::ALIAS.'.createdAt'));
        if ( $agent ){
            $qb->andwhere(self::ALIAS.'.superior =?1')
                ->setParameter(1, $agent);
        }
        if ( $date ) {
            $qb->andWhere(self::ALIAS.'.createdAt > :last')
                ->setParameter('last', $date, Type::DATETIME);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}