<?php

namespace PaymentBundle\Business\Manager\Payment;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use FOS\MessageBundle\MessageBuilder\ReplyMessageBuilder;
use FOS\MessageBundle\Model\MessageInterface;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Event\Notification\NotificationEvents;
use UserBundle\Business\Manager\NotificationManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;

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