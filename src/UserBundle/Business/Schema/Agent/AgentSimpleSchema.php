<?php

namespace UserBundle\Business\Schema\Agent;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

class AgentSimpleSchema extends SchemaProvider
{
    protected $resourceType = 'agent';

    public function getId($agent)
    {
        /** @var Group $author */
        return $agent->getId();
    }

    public function getAttributes($agent)
    {
        /** @var Agent $agent */
        return [
            'agentId'              => $agent->getAgentId(),
            'firstName'            => $agent->getFirstName(),
            'lastName'             => $agent->getLastName(),
            'email'                => $agent->getEmail(),
        ];
    }

    /**
     * @param Agent $agent
     * @param bool $isPrimary
     * @param array $includeList
     * @return array
     */
    public function getRelationships($agent, $isPrimary, array $includeList)
    {
        return [];
    }

    public function getIncludePaths(){
        return [];
    }

}