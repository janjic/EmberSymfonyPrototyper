<?php

namespace PaymentBundle\Business\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use PaymentBundle\Entity\PaymentInfo;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Agent;

/**
 * Class PaymentInfoRepository
 * @package PaymentBundle\Business\Repository
 */
class PaymentInfoRepository extends EntityRepository
{
    const ALIAS          = 'paymentInfo';
    const AGENT_ALIAS    = 'agent';
    const GROUP_ALIAS    = 'g';
    const SUPERIOR_ALIAS = 'superior';
    const ROLE_ALIAS     = 'role';

    /**
     * Save payments array
     * @param ArrayCollection $payments
     * @return ArrayCollection|\Exception
     */
    public function saveArray($payments)
    {
        try {
            foreach ($payments as $payment) {
                $this->_em->persist($payment);
            }

            $this->_em->flush();
        } catch (Exception $e){
            return $e;
        }

        return $payments;
    }

    /**
     * @param PaymentInfo $payment
     * @return PaymentInfo|\Exception
     */
    public function edit($payment)
    {
        try {
            $this->_em->merge($payment);
            $this->_em->flush();
        } catch (Exception $e){
            return $e;
        }

        return $payment;
    }

    /**
     * @param Agent $agent
     * @param null|int $customerId
     * @return array
     */
    public function getPaymentInfoForAgent($agent, $customerId = null)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->where(self::ALIAS.'.agent = ?1');
        $qb->setParameter(1, $agent);

        if ($customerId) {
            $qb->andWhere(self::ALIAS.'.customerId = ?2');
            $qb->setParameter(2, $customerId);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findPayment($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select(self::ALIAS, self::AGENT_ALIAS);
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);

        if (intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }

        return $qb->getQuery()->getResult();
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
        $firstResult = ((int) $page-1)* (int) $offset;

        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select(self::ALIAS, self::AGENT_ALIAS);
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);

        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy($sortParams[0], $sortParams[1]);

        if (array_key_exists('paymentState', $additionalParams)) {
            if ($additionalParams['paymentState'] === ''){
                $qb->andWhere(self::ALIAS.'.state IS NULL');
            } else {
                $qb->andWhere(self::ALIAS.'.state = ?1');
                $qb->setParameter(1, $additionalParams['paymentState'] === 'true' ? 1 : 0);
            }
        }

        if (array_key_exists('agent', $additionalParams)) {
            /** @var Agent $agent */
            $agent = $additionalParams['agent'];
            $qb->andWhere(self::AGENT_ALIAS.'.id = :agent_id');
            $qb->setParameter('agent_id', $agent->getId());
        }

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
        $oQ0 = $this->createQueryBuilder(self::ALIAS);

        $oQ0->select(self::ALIAS, self::AGENT_ALIAS);
        $oQ0->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);

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
                    if ($key == 'address.country') {
                        $oQ0->leftJoin(self::AGENT_ALIAS.'.address', 'address');
                    }

                    if ($key == 'startDate') {
                        $oQ0->andWhere(self::ALIAS.'.createdAt > :'.$key);
                        $oQ0->setParameter($key, $param);
                    } else if ($key == 'endDate'){
                        $oQ0->andWhere(self::ALIAS.'.createdAt < :'.$key);
                        $oQ0->setParameter($key, $param);
                    } else if ($key == 'paymentInfo.type'){
                        $type = $param === 'Commission' ? PaymentInfoManager::COMMISSION_TYPE : PaymentInfoManager::BONUS_TYPE;
                        $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%' . $type . '%')));
                    } else {
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

        if (array_key_exists('paymentState', $additionalParams)) {
            if ($additionalParams['paymentState'] === ''){
                $oQ0->andWhere(self::ALIAS.'.state IS NULL');
            } else {
                $oQ0->andWhere(self::ALIAS.'.state = ?1');
                $oQ0->setParameter(1, $additionalParams['paymentState'] === 'true' ? 1 : 0);
            }
        }

        if (array_key_exists('agent', $additionalParams)) {
            /** @var Agent $agent */
            $agent = $additionalParams['agent'];
            $oQ0->andWhere(self::AGENT_ALIAS.'.id = :agent_id');
            $oQ0->setParameter('agent_id', $agent->getId());
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
     * @param $currency
     * @param $ratio
     * @param Agent $agent
     * @return array
     */
    public function getCommissionsByAgent($currency, $ratio, $agent)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('CONCAT('.self::AGENT_ALIAS.'.firstName, \' \','.self::AGENT_ALIAS.'.lastName) as agentName');
        $qb->addselect(self::AGENT_ALIAS.'.baseImageUrl');
        $qb->addselect(self::GROUP_ALIAS.'.name as groupName');
        $qb->addSelect(self::AGENT_ALIAS.'.id as agentId');
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".packagesCommission * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".packagesCommission,2) END as packagesCommission");
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".connectCommission * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".connectCommission,2) END as connectCommission");
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".setupFeeCommission * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".setupFeeCommission,2) END as setupFeeCommission");
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".streamCommission * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".streamCommission,2) END as streamCommission");
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".totalCommission * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".totalCommission,2) END as totalCommission")
            ->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS)
            ->leftJoin(self::AGENT_ALIAS.'.group', self::GROUP_ALIAS)
            ->groupBy(self::ALIAS.'.agent')
            ->orderBy('totalCommission', 'DESC')
            ->where(self::ALIAS.'.state = 1')
            ->andWhere(self::AGENT_ALIAS.'.lft > '.$agent->getLft())
            ->andWhere(self::AGENT_ALIAS.'.rgt < '.$agent->getRgt())
            ->andWhere($qb->expr()->like(self::ALIAS.'.paymentType', $qb->expr()->literal(PaymentInfoManager::COMMISSION_TYPE)))
            ->andWhere(self::ALIAS.'.payedAt > :date')
            ->setParameter('date', new \DateTime('-3 month'))
            ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }


    /**
     * @param $currency
     * @param $ratio
     * @return array
     */
    public function getBonusesByAgent($currency, $ratio)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('CONCAT('.self::AGENT_ALIAS.'.firstName, \' \','.self::AGENT_ALIAS.'.lastName) as agentName');
        $qb->addSelect("CASE WHEN (".self::ALIAS.".currency != '".$currency."') THEN ROUND(".self::ALIAS.".bonusValue * ".$ratio.",2) ELSE ROUND(".self::ALIAS.".bonusValue,2) END as bonusValue");
        $qb->addSelect(self::ALIAS.'.payedAt as date');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->andWhere(self::ALIAS.'.payedAt > :date')
            ->andWhere($qb->expr()->like(self::ALIAS.'.paymentType', $qb->expr()->literal(PaymentInfoManager::BONUS_TYPE)))
            ->orderBy(self::ALIAS.'.agent')
            ->groupBy(self::ALIAS.'.agent')
            ->setParameter('date', new \DateTime('-3 month'))
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }



    /**
     * @param mixed $page
     * @param mixed $offset
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @return array
     */
    public function findAllForActiveAgent($page, $offset, $sortParams, $additionalParams)
    {
        $firstResult = ((int) $page-1)* (int) $offset;

        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::SUPERIOR_ALIAS.'.firstName, \' \','.self::SUPERIOR_ALIAS.'.lastName) as full_name',
            self::SUPERIOR_ALIAS.'.baseImageUrl as image_webPath', self::SUPERIOR_ALIAS.'.nationality', self::GROUP_ALIAS.'.name as role_name', self::SUPERIOR_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::AGENT_ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::SUPERIOR_ALIAS.'.group', self::GROUP_ALIAS);
        $qb->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);
        /**
         * Change to < when finished
         */

        $qb->andWhere(self::ALIAS.'.payedAt > :date');
        $qb->andWhere(self::ALIAS.'.state = 1');
        /**
         * uncomment this when data arrives!!!!!
         */
        $qb->andWhere($qb->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_ACTIVE_AGENT.'%\''));

        $qb->setFirstResult($firstResult)->setMaxResults($offset);


        $qb->groupBy(self::SUPERIOR_ALIAS.'.id');
        $qb->orderBy('active_agents_numb', 'DESC');
        $qb->setParameter('date', new \DateTime('-6 month'));

        return $qb->getQuery()->getResult();
    }


    /**
     * @param $searchParams
     * @param $sortParams
     * @param $additionalParams
     * @param bool $isCountSearch
     * @return array
     */
    public function searchPromotionsForActiveAgent($searchParams, $sortParams, $additionalParams, $isCountSearch = false)
    {
        $oQ0 = $this->createQueryBuilder(self::ALIAS);
        $oQ0->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::SUPERIOR_ALIAS.'.firstName, \' \','.self::SUPERIOR_ALIAS.'.lastName) as full_name',
            self::SUPERIOR_ALIAS.'.baseImageUrl as image_webPath', self::SUPERIOR_ALIAS.'.nationality', self::GROUP_ALIAS.'.name as role_name', self::SUPERIOR_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $oQ0->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $oQ0->leftJoin(self::AGENT_ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $oQ0->leftJoin(self::SUPERIOR_ALIAS.'.group', self::GROUP_ALIAS);
        $oQ0->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);

        /**
         * Change to < when finished
         */
        $oQ0->andWhere(self::ALIAS.'.payedAt > :date');
        $oQ0->andWhere(self::ALIAS.'.state = 1');

        /**
         * uncomment this when data arrives!!!!!
         */
//        $oQ0->andWhere($oQ0->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_ACTIVE_AGENT.'%\''));


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
                    $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%' . $param . '%')));
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

        if ($isCountSearch) {
            $oQ0->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb');
        } else {
            $oQ0->setFirstResult($firstResult)->setMaxResults($offset);
        }

        $oQ0->groupBy(self::SUPERIOR_ALIAS.'.id');
        $oQ0->orderBy('active_agents_numb', 'DESC');
        $oQ0->setParameter('date', new \DateTime('-6 month'));

        return $oQ0->getQuery()->getResult();
    }

    /**
     * @param $request
     * @param $isCountSearch
     * @return array
     */
    public function getPromotionSuggestionsForActiveAgent($request, $isCountSearch)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::SUPERIOR_ALIAS.'.firstName, \' \','.self::SUPERIOR_ALIAS.'.lastName) as full_name',
            self::SUPERIOR_ALIAS.'.baseImageUrl as image_webPath', self::SUPERIOR_ALIAS.'.id as agent_id', self::SUPERIOR_ALIAS.'.nationality', self::GROUP_ALIAS.'.name as role_name', self::SUPERIOR_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::AGENT_ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::SUPERIOR_ALIAS.'.group', self::GROUP_ALIAS);
        $qb->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);

        /**
         * Change to < when finished
         */
        $qb->andWhere(self::ALIAS.'.payedAt > :date');
        $qb->setParameter('date', new \DateTime('-6 month'));
        $qb->andWhere(self::ALIAS.'.state = 1');

        /**
         * uncomment this when data arrives!!!!!
         */
        $qb->andWhere($qb->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_ACTIVE_AGENT.'%\''));

        /**
         * Apply search if params exist
         */
        if($request) {
            $page = $request->get('page');
            $offset = $request->get('offset');
            $firstResult = 0;
            if ($page != 1) {
                $firstResult = ($page - 1) * $offset;
            }

            $rules = json_decode($request->get('filters'))->rules;
            if(sizeof($rules)){
                $rule = $rules[0]->data;
                $qb->andWhere($qb->expr()->like(self::SUPERIOR_ALIAS.'.firstName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::SUPERIOR_ALIAS.'.lastName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::SUPERIOR_ALIAS.'.username', $qb->expr()->literal($rule.'%')));
            }

            $qb->setFirstResult($firstResult);
            $qb->setMaxResults($offset);
        }

        /**
         * UnComment having clause when finished!!!!
         * $qb->having('active_agents_numb >= 10');
         */

        $qb->groupBy(self::SUPERIOR_ALIAS.'.id');
        $qb->orderBy('active_agents_numb', 'DESC');

        if($isCountSearch){
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb');

            return $qb->getQuery()->getResult();
        }

        $qb->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $request
     * @param $isCountSearch
     * @return array
     */
    public function getPromotionSuggestionsForReferee($request, $isCountSearch)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::AGENT_ALIAS.'.firstName, \' \','.self::AGENT_ALIAS.'.lastName) as full_name',
            self::AGENT_ALIAS.'.baseImageUrl as image_webPath', self::AGENT_ALIAS.'.nationality', self::AGENT_ALIAS.'.id as agent_id', self::GROUP_ALIAS.'.name as role_name', self::AGENT_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::AGENT_ALIAS.'.group', self::GROUP_ALIAS);
        $qb->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);
        /**
         * Change to < when finished
         */
        $qb->andWhere(self::ALIAS.'.payedAt > :date');
        $qb->setParameter('date', new \DateTime('-6 month'));
        $qb->andWhere(self::ALIAS.'.state = 1');
        $qb->andWhere($qb->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_REFEREE.'%\''));

        /**
         * Apply search if params exist
         */
        if($request) {
            $page = $request->get('page');
            $offset = $request->get('offset');
            $firstResult = 0;
            if ($page != 1) {
                $firstResult = ($page - 1) * $offset;
            }

            $rules = json_decode($request->get('filters'))->rules;
            if(sizeof($rules)){
                $rule = $rules[0]->data;
                $qb->andWhere($qb->expr()->like(self::AGENT_ALIAS.'.firstName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::AGENT_ALIAS.'.lastName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::AGENT_ALIAS.'.username', $qb->expr()->literal($rule.'%')));
            }

            $qb->setFirstResult($firstResult);
            $qb->setMaxResults($offset);
        }


        /**
         * UnComment having clause when finished!!!!
         *$qb->having('active_agents_numb >= 12');
         */
        $qb->groupBy(self::AGENT_ALIAS.'.id');
        $qb->orderBy('active_agents_numb', 'DESC');

        if($isCountSearch){
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb');

            return $qb->getQuery()->getResult();
        }


        return $qb->getQuery()->getResult();
    }

    /**
     * @param $request
     * @param $isCountSearch
     * @return array
     */
    public function getDowngradeSuggestionsForMasterAgent($request, $isCountSearch)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::SUPERIOR_ALIAS.'.firstName, \' \','.self::SUPERIOR_ALIAS.'.lastName) as full_name',
            self::SUPERIOR_ALIAS.'.baseImageUrl as image_webPath', self::SUPERIOR_ALIAS.'.nationality', self::SUPERIOR_ALIAS.'.id as agent_id', self::GROUP_ALIAS.'.name as role_name', self::SUPERIOR_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::AGENT_ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::SUPERIOR_ALIAS.'.group', self::GROUP_ALIAS);
        $qb->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);

        /**
         * Change to < when finished
         */
        $qb->andWhere(self::ALIAS.'.payedAt > :date');
        $qb->andWhere(self::ALIAS.'.state = 1');
        $qb->andWhere($qb->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_MASTER_AGENT.'%\''));
        $qb->setParameter('date', new \DateTime('-6 month'));

        /**
         * Apply search if params exist
         */
        if($request) {
            $page = $request->get('page');
            $offset = $request->get('offset');
            $firstResult = 0;
            if ($page != 1) {
                $firstResult = ($page - 1) * $offset;
            }

            $rules = json_decode($request->get('filters'))->rules;
            if(sizeof($rules)){
                $rule = $rules[0]->data;
                $qb->andWhere($qb->expr()->like(self::SUPERIOR_ALIAS.'.firstName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::SUPERIOR_ALIAS.'.lastName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::SUPERIOR_ALIAS.'.username', $qb->expr()->literal($rule.'%')));
            }

            $qb->setFirstResult($firstResult);
            $qb->setMaxResults($offset);
        }


        /**
         * UnComment having clause when finished!!!!
         *
         */
        $qb->having('active_agents_numb < 10');
        $qb->groupBy(self::SUPERIOR_ALIAS.'.id');
        $qb->orderBy('active_agents_numb', 'DESC');

        if($isCountSearch){
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb');

            return $qb->getQuery()->getResult();
        }


        return $qb->getQuery()->getResult();
    }


    /**
     * @return array
     */
    public function getDowngradeSuggestionsForActiveAgent($request, $isCountSearch)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb', 'CONCAT('.self::AGENT_ALIAS.'.firstName, \' \','.self::AGENT_ALIAS.'.lastName) as full_name',
            self::AGENT_ALIAS.'.baseImageUrl as image_webPath', self::AGENT_ALIAS.'.nationality', self::AGENT_ALIAS.'.id as agent_id', self::GROUP_ALIAS.'.name as role_name', self::AGENT_ALIAS.'.email', self::ROLE_ALIAS.'.role as role_code');
        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->leftJoin(self::AGENT_ALIAS.'.group', self::GROUP_ALIAS);
        $qb->leftJoin(self::GROUP_ALIAS.'.roles', self::ROLE_ALIAS);

        /**
         * Change to < when finished
         */
        $qb->andWhere(self::ALIAS.'.payedAt > :date');
        $qb->andWhere(self::ALIAS.'.state = 1');
        $qb->andWhere($qb->expr()->like(self::ROLE_ALIAS.'.role', '\'%'.RoleManager::ROLE_ACTIVE_AGENT.'%\''));
        $qb->setParameter('date', new \DateTime('-6 month'));

        /**
         * Apply search if params exist
         */
        if($request) {
            $page = $request->get('page');
            $offset = $request->get('offset');
            $firstResult = 0;
            if ($page != 1) {
                $firstResult = ($page - 1) * $offset;
            }

            $rules = json_decode($request->get('filters'))->rules;
            if(sizeof($rules)){
                $rule = $rules[0]->data;
                $qb->andWhere($qb->expr()->like(self::AGENT_ALIAS.'.firstName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::AGENT_ALIAS.'.lastName', $qb->expr()->literal($rule.'%')).' OR '.
                    $qb->expr()->like(self::AGENT_ALIAS.'.username', $qb->expr()->literal($rule.'%')));
            }

            $qb->setFirstResult($firstResult);
            $qb->setMaxResults($offset);
        }


        /**
         * UnComment having clause when finished!!!!
         *
         */
        $qb->having('active_agents_numb < 12');
        $qb->groupBy(self::AGENT_ALIAS.'.id');
        $qb->orderBy('active_agents_numb', 'DESC');

        if($isCountSearch){
            $qb->select('COUNT(DISTINCT '.self::ALIAS.'.id) as active_agents_numb');

            return $qb->getQuery()->getResult();
        }


        return $qb->getQuery()->getResult();
    }

}