<?php

namespace ConversationBundle\Business\Manager\Thread;

use ConversationBundle\Entity\Thread;
use FSerializerBundle\Serializer\JsonApiMany;
use UserBundle\Entity\Agent;

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