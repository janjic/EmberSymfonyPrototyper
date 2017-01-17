<?php

namespace PaymentBundle\Business\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Doctrine\DBAL\Types\Type;
use PaymentBundle\Entity\PaymentInfo;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Entity\Agent;

/**
 * Class PaymentInfoRepository
 * @package PaymentBundle\Business\Repository
 */
class PaymentInfoRepository extends EntityRepository
{
    const ALIAS       = 'paymentInfo';
    const AGENT_ALIAS = 'agent';
    const GROUP_ALIAS = 'g';

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
        $qb->addSelect(self::AGENT_ALIAS.'.baseImageUrl');
        $qb->addSelect(self::GROUP_ALIAS.'.name as groupName');
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
    public function newCommissionsCount($agent, $period)
    {
        switch ($period){
            case 'today': $date = new \DateTime('-1 day');break;
            case 'month': $date = new \DateTime('-1 month');break;
            default: $date = null;
        }

        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select(self::ALIAS.'.currency ,SUM('.self::ALIAS.'.totalCommission'.') as total_commission_sum');
        $qb->where($qb->expr()->isNotNull(self::ALIAS.'.createdAt'));
        if ( $agent ){
            $qb->andwhere(self::ALIAS.'.agent =?1')
                ->setParameter(1, $agent);
        }
        if ( $date ) {
            $qb->andWhere(self::ALIAS.'.createdAt > :last')
                ->setParameter('last', $date, Type::DATETIME);
        }
        $qb->groupBy(self::ALIAS.'.currency');

//        var_dump($qb->getQuery()->getResult());die();
        return $qb->getQuery()->getResult();
    }


    /**
     * @param Agent  $agent
     * @param string $currency
     * @param string $ratio
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getEarningsForAgent(Agent $agent, $currency, $ratio, $dateFrom, $dateTo)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".packagesCommission * ".$ratio.", 2) 
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".packagesCommission, 2) 
                             ELSE 0 END) as packagesCommission");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".connectCommission * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".connectCommission, 2)
                             ELSE 0 END) as connectCommission");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".setupFeeCommission * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".setupFeeCommission, 2)
                             ELSE 0 END) as setupFeeCommission");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".streamCommission * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".streamCommission, 2)
                             ELSE 0 END) as streamCommission");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".totalCommission * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".totalCommission, 2)
                             ELSE 0 END) as totalCommission");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".bonusValue * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 1) THEN ROUND(".self::ALIAS.".bonusValue, 2)
                             ELSE 0 END) as totalBonus");

        /* Unprocessed */
        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 0) THEN ROUND(".self::ALIAS.".totalCommission * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 0) THEN ROUND(".self::ALIAS.".totalCommission, 2)
                             ELSE 0 END) as unprocessedCommissions");

        $qb->addSelect("SUM( CASE WHEN (".self::ALIAS.".currency != '".$currency."' AND ".self::ALIAS.".state = 0) THEN ROUND(".self::ALIAS.".bonusValue * ".$ratio.", 2)
                                  WHEN (".self::ALIAS.".currency = '".$currency."' AND ".self::ALIAS.".state = 0) THEN ROUND(".self::ALIAS.".bonusValue, 2)
                             ELSE 0 END) as unprocessedBonus");

        $qb->leftJoin(self::ALIAS.'.agent', self::AGENT_ALIAS);
        $qb->andWhere(self::AGENT_ALIAS.'.id = :agent_id')
            ->setParameter('agent_id', $agent->getId());

        if ($dateFrom) {
            $qb->andWhere(self::ALIAS.'.createdAt > :date_f');
            $qb->setParameter('date_f', $dateFrom);
        }

        if ($dateTo){
            $qb->andWhere(self::ALIAS.'.createdAt < :date_t');
            $qb->setParameter('date_t', $dateTo);
        }

        return $qb->getQuery()->getSingleResult();
    }
}