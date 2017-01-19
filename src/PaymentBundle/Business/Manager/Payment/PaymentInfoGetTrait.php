<?php

namespace PaymentBundle\Business\Manager\Payment;

/**
 * Class PaymentInfoGetTrait
 * @package PaymentBundle\Business\Manager\Payment
 */
trait PaymentInfoGetTrait
{
    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        return $this->serializePaymentInfo($this->repository->findPayment($id));
    }
}