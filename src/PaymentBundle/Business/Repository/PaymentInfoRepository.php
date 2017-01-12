<?php

namespace PaymentBundle\Business\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use PaymentBundle\Entity\PaymentInfo;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Entity\Agent;

/**
 * Class PaymentInfoRepository
 * @package PaymentBundle\Business\Repository
 */
class PaymentInfoRepository extends EntityRepository
{
    const ALIAS = 'paymentInfo';

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
            $qb->where(self::ALIAS.'.customerId = ?2');
            $qb->setParameter(2, $customerId);
        }

        return $qb->getQuery()->getResult();
    }

    public function newCommissionsCount($agent, $period)
    {
        var_dump($period);die();
        switch ($period){
            case 'today': $date = new \DateTime('-1 day');break;
            case 'month': $date = new \DateTime('-1 month');break;
            default: $date = null;
        }

        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->select($qb->expr()->count(self::ALIAS.'.id'));
        $qb->where($qb->expr()->isNotNull(self::ALIAS.'.createdAt'));
        if ( $agent ){
            $qb->andwhere(self::ALIAS.'.agent =?1')
                ->setParameter(1, $agent);
        }
        if ( $date ) {
            $qb->andWhere(self::ALIAS.'.createdAt > :last')
                ->setParameter('last', $date, Type::DATETIME);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

}