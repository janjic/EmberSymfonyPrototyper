<?php

namespace PaymentBundle\Business\Manager\Payment;

use PaymentBundle\Entity\PaymentInfo;

/**
 * Class PaymentInfoUpdateTrait
 * @package PaymentBundle\Business\Manager\Payment
 */
trait PaymentInfoUpdateTrait
{
    public function updateResource($data)
    {
        /** @var PaymentInfo $payment */
        $payment = $this->deserializePaymentInfo($data);
        /** @var PaymentInfo $paymentDB */
        $paymentDB = $this->repository->findPayment($payment->getId());

        $paymentDB->setMemo($payment->getMemo());
        $paymentDB = $this->repository->edit($paymentDB);

        return $this->serializePaymentInfo($paymentDB);
    }
}