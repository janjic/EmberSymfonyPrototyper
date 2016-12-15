<?php

namespace ConversationBundle\Util;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;

/**
 * Class TicketSerializerInfo
 */
class TicketSerializerInfo
{

    public static $mappings = array(
        'createdBy'    => array('class' => Agent::class, 'type'=>'agents'),
        'forwardedTo'  => array('class' => Agent::class, 'type'=>'agents'),
        'file'         => array('class' => File::class, 'type'=>'files'),
        'thread'       => array('class' => Thread::class, 'type'=>'threads'),
        'messages'     => array('class' => Message::class, 'type'=>'messages'),
        'sender'       => array('class' => Agent::class, 'type'=>'agents'),
    );

    public static $relations = array('createdBy', 'forwardedTo', 'file', 'thread', 'thread.messages', 'thread.messages.sender');

}