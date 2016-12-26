<?php

namespace ConversationBundle\Business\Manager\Thread;

use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use FSerializerBundle\Serializer\JsonApiMany;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class JsonApiThreadSerializationTrait
 * @package ConversationBundle\Business\Manager\Thread
 */
trait JsonApiThreadSerializationTrait
{
    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeThread($content, $mappings = null)
    {
        $relations = array();
        if (!$mappings) {
            $mappings = array(
                'thread' => array('class' => Thread::class, 'type'=>'threads'),
            );
        }

        return $this->fSerializer->setDeserializationClass(Thread::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param array $metaTags
     * @param null $mappings
     * @param null $relations
     * @return mixed
     */
    public function serializeThread($content, $metaTags = [], $mappings = null, $relations = null)
    {
        if (!$relations) {
            $relations = array('createdBy', 'participants');
        }
        if (!$mappings) {
            $mappings = array(
                'thread'       => array('class' => Thread::class, 'type'=>'threads'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class),
                'createdBy'    => array('class' => Agent::class, 'type'=>'agents'),
            );
        }

        $serialize = $this->fSerializer->setDeserializationClass(Thread::class)->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }

    /**
     * @param $content
     * @param array $metaTags
     * @param null $mappings
     * @return mixed
     */
    public function serializeThreadWithMessages($content, $metaTags = [], $mappings = null)
    {
        $relations = array('createdBy', 'participants');
        if (!$mappings) {
            $mappings = array(
                'thread'       => array('class' => Thread::class, 'type'=>'threads'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class),
                'createdBy'    => array('class' => Agent::class, 'type'=>'agents'),
            );
        }

        $serialize = $this->fSerializer->setDeserializationClass(Thread::class)->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }
}