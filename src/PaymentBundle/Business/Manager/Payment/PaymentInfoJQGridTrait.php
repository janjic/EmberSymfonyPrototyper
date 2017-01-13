<?php

namespace PaymentBundle\Business\Manager\Payment;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
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
 * Class PaymentInfoJQGridTrait
 * @package PaymentBundle\Business\Manager\Payment
 */
trait PaymentInfoJQGridTrait
{
    /**
     * @param $request
     * @return ArrayCollection
     */
    public function jqgridAction($request)
    {
        $params = null;
        $searchParams = null;
        $page = $request->get('page');
        $offset = $request->get('offset');
        $promoCode = $request->get('promoCode');

        $searchFields = array(
            'id' => 'paymentInfo.id',
            'country' => 'address.country',
            'type' => 'paymentInfo.paymentType',
            'startDate' => 'startDate',
            'endDate' => 'endDate',
            'agent' => 'agent.id'
        );

        $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
        $params['page'] = $page;
        $params['offset'] = $offset;
        $additionalParams = array('or'=>false);
        $additionalParams['paymentState'] = $request->get('paymentState');

        if ($filters = $request->get('filters')) {
            $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
            $filters = json_decode($filters);
            if ($filters->groupOp == 'or') {
                $additionalParams['or'] = true;
            }
            foreach ($rules = $filters->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, false, $promoCode);
        } else {
            $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, $additionalParams, $promoCode);
        }

        $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, true, $promoCode)[0][1];
        $pageCount = ceil($size / $offset);

        return $this->serializePaymentInfo($agents, [
            'totalItems' => $size,
            'pages' => $pageCount,
            'page' => $page
        ]);
    }
}