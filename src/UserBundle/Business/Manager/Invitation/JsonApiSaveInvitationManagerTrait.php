<?php

namespace UserBundle\Business\Manager\Invitation;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Invitation;
use UserBundle\Entity\Role;

/**
 * Class JsonApiSaveInvitationManagerTrait
 * @package UserBundle\Business\Manager\Invitation
 */
trait JsonApiSaveInvitationManagerTrait
{

    /**
     * @param string $data
     * @return mixed
     */
    public function saveResource($data)
    {
        /** @var Invitation $invitation */
        $invitation = $this->deserializeInvitation($data);

        $invitation->setAgent($this->repository->getReferenceForClass($invitation->getAgent()->getId(), Agent::class));
        $invitationData = $this->sendMail($invitation);

        return $this->createJsonAPiSaveResponse($invitationData);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        if(is_array($data) && array_key_exists('id', $data)){
            return AgentApiResponse::INVITATION_SAVED_SUCCESSFULLY($data['id']);
        } else {
            return AgentApiResponse::ERROR_RESPONSE($data);
        }
    }
}