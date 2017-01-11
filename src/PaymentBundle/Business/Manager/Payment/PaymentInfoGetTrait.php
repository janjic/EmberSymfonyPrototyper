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
use PaymentBundle\Business\Manager\PaymentInfoManager;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Event\Notification\NotificationEvents;
use UserBundle\Business\Manager\NotificationManager;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use UserBundle\Entity\Settings\Commission;

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
        return $this->serializePaymentInfo($this->repository->findPaymentInfo($id));
    }
}