<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use UserBundle\Entity\Agent;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class AgentRepository extends NestedTreeRepository
{
    const ALIAS          = 'agent';
    const ADDRESS_ALIAS  = 'address';
    const GROUP_ALIAS    = 'g';
    const IMAGE_ALIAS    = 'image';
    const SUPERIOR_ALIAS = 'superior';
    const CHILDREN_ALIAS = 'children';

    /**
     * @param Agent $agent
     * @return Agent
     * @throws \Exception
     */
    public function saveAgent($agent)
    {
        try {
            if(!is_null($agent->getSuperior())){
                $this->persistAsFirstChildOf($agent, $agent->getSuperior());
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
     * @return array
     */
    public function findAgentById($id)
    {

        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::ADDRESS_ALIAS, self::IMAGE_ALIAS, self::GROUP_ALIAS, self::SUPERIOR_ALIAS, self::CHILDREN_ALIAS);
        $qb->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS)
            ->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS)
            ->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS)
            ->leftJoin(self::ALIAS.'.image', self::IMAGE_ALIAS)
            ->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }


        return $qb->getQuery()->getResult();
    }

    /**
     * @param Agent $agent
     * @param Agent $dbSuperior
     * @return Agent
     * @throws \Exception
     */
    public function edit(Agent $agent, $dbSuperior)
    {
        /**
         * @var Agent $newSuperior
         */
        $newSuperior = $this->findAgentById($agent->getSuperior()->getId());
        try {
            if(!is_null($agent->getSuperior())){
                if(!is_null($dbSuperior) && in_array($newSuperior, $agent->getChildren()->getValues())){
//                    var_dump($agent->getLvl());exit;
                    $this->persistAsFirstChildOf($newSuperior, $dbSuperior);
                    $this->_em->flush();
//                    $this->persistAsFirstChildOf($agent, $newSuperior);
                } else {
                    $this->persistAsFirstChildOf($agent, $newSuperior);
                }
            } else {
                $this->persistAsFirstChild($agent);
            }
            $this->_em->flush();
            $this->reorderAll();
        } catch (\Exception $e) {
            throw $e;
            return new Agent();
        }

        return $agent;
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
                    if ($key == 'agent.locked') {
                        if ($param != -1) {
                            $oQ0->andWhere($key.' = '.$param);
                        }
                    } else if($key == 'address.country'){
                        $oQ0->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS);
                        $oQ0->andWhere($oQ0->expr()->like(self::ADDRESS_ALIAS.'.country', $oQ0->expr()->literal('%'.$param.'%')));
                    }  else if($key == 'group.name'){
                        $oQ0->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);
                        $oQ0->andWhere($oQ0->expr()->like(self::GROUP_ALIAS.'.name', $oQ0->expr()->literal('%'.$param.'%')));
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
}