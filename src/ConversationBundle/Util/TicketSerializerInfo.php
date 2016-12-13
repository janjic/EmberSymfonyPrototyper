<?php

namespace ConversationBundle\Util;
use ConversationBundle\Entity\Thread;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;

/**
 * Class TicketSerializerInfo
 */
class TicketSerializerInfo
{

    public static $mappings = array(
        'createdBy' => array('class' => Agent::class, 'type'=>'agents'),
        'forwardedTo' => array('class' => Agent::class, 'type'=>'agents'),
        'file' => array('class' => File::class, 'type'=>'files'),
        'thread' => array('class' => Thread::class, 'type'=>'threads'),
    );

    public static $relations = array('createdBy', 'forwardedTo', 'file', 'thread');

}