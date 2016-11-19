<?php

namespace UserBundle\Business\Schema\Agent;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

class AgentSchema extends SchemaProvider
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
            'title'                => $agent->getTitle(),
            'agentID'              => $agent->getAgentId(),
            'firstName'            => $agent->getFirstName(),
            'lastName'             => $agent->getLastName(),
            'email'                => $agent->getEmail(),
            'privateEmail'         => $agent->getPrivateEmail(),
            'socialSecurityNumber' => $agent->getSocialSecurityNumber(),
            'nationality'          => $agent->getNationality(),
            'birthDate'            => $agent->getBirthDate(),
            'bankName'             => $agent->getBankName(),
            'bankAccountNumber'    => $agent->getBankAccountNumber(),
            'agentBackground'      => $agent->getAgentBackground(),

        ];
    }

    public function getRelationships($agent, $isPrimary, array $includeList)
    {
        /** @var Agent $agent */
        return [
            'group'   => [self::DATA => $agent->getGroup()],
            'image'   => [self::DATA => $agent->getImage()],
            'address' => [self::DATA => $agent->getAddress()],
            'superior'=> [self::DATA => $agent->getSuperior()]
        ];
    }

    public function getIncludePaths(){
        return ['group', 'image', 'address', 'superior'];
    }

}