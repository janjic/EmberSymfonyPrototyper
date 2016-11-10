<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;


/**
 * Class UserRepository
 * @package UserBundle\Business\Repository
 */
class UserRepository extends EntityRepository
{
    const ALIAS = 'u';
    const JOIN_WITH_ADDRESS = 'address';
    const JOIN_WITH_IMAGE = 'image';

    /**
     * @param null $id
     * @return array
     */
    public function findUsers ($id = null)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u.id', 'u.firstName', 'u.lastName', 'u.baseImageUrl  as image', 'u.username');
        $id ? $qb->where('u.id = ?1')->setParameter(1, $id):false;

        return  $qb->select()->getQuery()->getArrayResult();
    }

    /**
     * @param null $id
     * @return array
     */
    public function findUsersNew ($id = null)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::JOIN_WITH_ADDRESS, self::JOIN_WITH_IMAGE);
        $qb->leftJoin(self::ALIAS.'.address', self::JOIN_WITH_ADDRESS);
        $qb->leftJoin(self::ALIAS.'.image', self::JOIN_WITH_IMAGE);
        $id ? $qb->where(self::ALIAS.'.id = ?1')->setParameter(1, $id):false;

        return  $qb->select()->getQuery()->getArrayResult();
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function edit(User $user)
    {
        try {
            $this->_em->merge($user);
            $this->_em->flush();

        } catch (Exception $e)
        {
            var_dump($e->getMessage());exit;
        }
        return $user;
    }

    /**
     * @param mixed $page
     * @param mixed $offset
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @return array
     */
    public function findAllUsersForJQGRID($page, $offset, $sortParams, $additionalParams)
    {
        $firstResult =0;
        if ($page !=1) {
            $firstResult = ($page-1)*$offset;
            // $offset = $page*$offset;
        }
        $qb= $this->createQueryBuilder(self::ALIAS)->select(self::ALIAS.'.id', self::ALIAS.'.username', self::ALIAS.'.firstName',
            self::ALIAS.'.lastName', self::ALIAS.'.enabled', self::ALIAS.'.locked');

        if (array_key_exists('search_param', $additionalParams)) {
            $qb->andWhere($qb->expr()->like(self::ALIAS.'.username', $qb->expr()->literal('%'.$additionalParams['search_param'].'%')));;
        }
        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy($sortParams[0], $sortParams[1]);
        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param mixed $searchParams
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @param bool  $isCountSearch
     * @return array
     */
    public function searchUsersForJQGRID($searchParams, $sortParams, $additionalParams, $isCountSearch = false)
    {
        $oQ0= $this->createQueryBuilder(self::ALIAS);
        if (!$isCountSearch) {
            $oQ0->select(self::ALIAS.'.id', self::ALIAS.'.username', self::ALIAS.'.firstName', self::ALIAS.'.lastName',
                self::ALIAS.'.enabled', self::ALIAS.'.locked');
        }

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
                    if ($key == 'u.locked' || $key == 'u.enabled') {
                        if ($param != -1) {
                            $oQ0->andWhere($key.' = '.$param);
                        }
                    }else {
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
            $oQ0->groupBy(self::ALIAS.'.id');
            $oQ0->setFirstResult($firstResult)->setMaxResults($offset);
        }


        if ($sortParams) {
            $oQ0->orderBy($sortParams[0], $sortParams[1]);
        }

        return $oQ0->getQuery()->getResult();
    }

}