<?php

namespace PaymentBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use PaymentBundle\Entity\PaymentInfo;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class PaymentInfoRepository
 * @package PaymentBundle\Business\Repository
 */
class PaymentInfoRepository extends EntityRepository
{
    const ALIAS = 'paymentInfo';

    public function save(PaymentInfo $file)
    {
        try {
            $this->_em->persist($file);
            $this->_em->flush();
        } catch (Exception $e){
             return $e;
        }

        return $file;
    }
}