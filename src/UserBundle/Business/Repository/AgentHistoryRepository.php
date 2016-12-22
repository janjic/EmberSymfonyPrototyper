<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Exception;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Agent;
use UserBundle\Entity\AgentHistory;
use UserBundle\Entity\Group;

/**
 * Class AgentHistoryRepository
 * @package UserBundle\Business\Repository
 */
class AgentHistoryRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS              = 'agent_history';
    const AGENT_ALIAS        = 'agent';
    const CHANGED_BY_ALIAS   = 'changed_by_agent';
    const CHANGED_FROM_ALIAS = 'changed_from';
    const CHANGED_TO_ALIAS   = 'changed_to';

    /**
     * @param AgentHistory $agentHistory
     * @return boolean
     */
    public function saveHistory($agentHistory)
    {
        try {
            $this->_em->persist($agentHistory);
            $this->_em->flush();
        } catch (Exception $e) {
            return false;
        }

        return true;
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
        $firstResult = ($page-1)*$offset;

        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::ALIAS.'.changedByAgent', self::CHANGED_BY_ALIAS);
        $qb->leftJoin(self::ALIAS.'.changedFrom', self::CHANGED_FROM_ALIAS);
        $qb->leftJoin(self::ALIAS.'.changedTo', self::CHANGED_TO_ALIAS);

        if (array_key_exists('search_param', $additionalParams)) {
            $qb->andWhere($qb->expr()->like(self::ALIAS.'.username', $qb->expr()->literal('%'.$additionalParams['search_param'].'%')));
        }

        if ($additionalParams['type']) {
            $qb->andWhere($qb->expr()->like(self::ALIAS . '.changedType', $qb->expr()->literal('%' . $additionalParams['type'] . '%')));
        }

        $qb->setFirstResult($firstResult)
            ->setMaxResults($offset)
            ->orderBy($sortParams[0], $sortParams[1]);

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

        $oQ0->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $oQ0->leftJoin(self::ALIAS.'.changedByAgent', self::CHANGED_BY_ALIAS);
        $oQ0->leftJoin(self::ALIAS.'.changedFrom', self::CHANGED_FROM_ALIAS);
        $oQ0->leftJoin(self::ALIAS.'.changedTo', self::CHANGED_TO_ALIAS);

        $firstResult = 0;
        $offset = 0;
        if ($searchParams) {
            if ($searchParams[0]['toolbar_search']) {
                $page = $searchParams[0]['page'];
                $offset = $searchParams[0]['rows'];
                $firstResult = ($page - 1) * $offset;

                array_shift($searchParams);
                foreach ($searchParams[0] as $key => $param) {
                    if ($key == 'agent.fullName') {
                        $oQ0->andWhere($oQ0->expr()->like(self::AGENT_ALIAS.'.firstName', $oQ0->expr()->literal('%'.$param.'%')));
                        $oQ0->orWhere($oQ0->expr()->like(self::AGENT_ALIAS.'.lastName', $oQ0->expr()->literal('%'.$param.'%')));
                    } else if($key == 'changed_by_agent.fullName'){
                        $oQ0->andWhere($oQ0->expr()->like(self::CHANGED_BY_ALIAS.'.firstName', $oQ0->expr()->literal('%'.$param.'%')));
                        $oQ0->orWhere($oQ0->expr()->like(self::CHANGED_BY_ALIAS.'.lastName', $oQ0->expr()->literal('%'.$param.'%')));
                    } else if ($key == 'agent_history.changedToSuspended') {
                        if ($param!= -1) {
                            $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%'.$param.'%')));
                        }
                    } else {
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
                $firstResult = ($page - 1) * $offset;

                if (!is_numeric($searchString)) {
                    switch ($searchOperator) {
                        case 'eq':
                            if ($searchString != '-1') {
                                $oQ0->andWhere(
                                    $oQ0->expr()->eq($searchField, $oQ0->expr()->literal($searchString))
                                );
                            }
                            break;
                        case 'cn':
                            $oQ0->andWhere(
                                $oQ0->expr()->like(
                                    $searchField,
                                    $oQ0->expr()->literal('%'.$searchString.'%')
                                )
                            );
                            break;
                    }
                }
            }
        }

        if ($additionalParams['type']) {
            $oQ0->andWhere($oQ0->expr()->like(self::ALIAS . '.changedType', $oQ0->expr()->literal('%' . $additionalParams['type'] . '%')));
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
}