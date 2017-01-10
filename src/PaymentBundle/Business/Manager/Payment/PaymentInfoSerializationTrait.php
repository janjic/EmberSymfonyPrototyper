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
 * Class PaymentInfoSerializationTrait
 * @package PaymentBundle\Business\Manager\Payment
 */
trait PaymentInfoSerializationTrait
{
    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializePaymentInfo($content, $mappings = null)
    {
        $relations = array('agent');
        if (!$mappings) {
            $mappings = array(
                'paymentInfo' => array('class' => PaymentInfo::class, 'type'=>'paymentInfo'),
                'agent'       => array('class' => Agent::class, 'type'=>'agents')
            );
        }

        return $this->fSerializer->setDeserializationClass(PaymentInfo::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param array $metaTags
     * @param null $mappings
     * @return mixed
     */
    public function serializePaymentInfo($content, $metaTags = [], $mappings = null)
    {
        $relations = array('agent');
        if (!$mappings) {
            $mappings = array(
                'paymentInfo' => array('class' => PaymentInfo::class, 'type'=>'payment-infos'),
                'agent'       => array('class' => Agent::class, 'type'=>'agents')
            );
        }

        $serialize = $this->fSerializer->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }
}