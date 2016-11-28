<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiOne;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;
use UserBundle\Entity\Agent;

class AgentSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'agents';

    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return $model->getId();
    }

    /**
     * @param mixed $agent
     * @param array|null $fields
     * @return array
     * @internal param mixed $post
     */
    public function getAttributes($agent, array $fields = null)
    {
        return [
            'title'                => $agent?$agent->getTitle():null,
            'roles'                => $agent?$agent->getRoles():null,
            'username'             => $agent?$agent->getUsername():null,
            'agentID'              => $agent?$agent->getAgentId():null,
            'firstName'            => $agent?$agent->getFirstName():null,
            'lastName'             => $agent?$agent->getLastName():null,
            'email'                => $agent?$agent->getEmail():null,
            'privateEmail'         => $agent?$agent->getPrivateEmail():null,
            'socialSecurityNumber' => $agent?$agent->getSocialSecurityNumber():null,
            'nationality'          => $agent?$agent->getNationality():null,
            'birthDate'            => $agent?$agent->getBirthDate():null,
            'bankName'             => $agent?$agent->getBankName():null,
            'bankAccountNumber'    => $agent?$agent->getBankAccountNumber():null,
            'agentBackground'      => $agent?$agent->getAgentBackground():null,
            'status'               => $agent?$agent->isLocked():null,

        ];
    }

    /**
     * @param Agent $agent
     * @return JsonApiRelationship
     */
    public function group($agent)
    {
        return new JsonApiRelationship(new JsonApiOne($agent->getGroup(), new GroupSerializer()));
    }

    /**
     * @param Agent $agent
     * @return JsonApiRelationship
     */
    public function superior($agent)
    {
        return new JsonApiRelationship(new JsonApiOne($agent->getSuperior(), $this));
    }

    /**
     * @param Agent $agent
     * @return JsonApiRelationship
     */
    public function image($agent)
    {
        return new JsonApiRelationship(new JsonApiOne($agent->getImage(), new ImageSerializer()));
    }

    /**
     * @param Agent $agent
     * @return JsonApiRelationship
     */
    public function address($agent)
    {
        return new JsonApiRelationship(new JsonApiOne($agent->getAddress(), new AddressSerializer()));
    }

    public function getDeserializationClass()
    {
        return Agent::class;
    }
}