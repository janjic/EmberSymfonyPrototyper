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

        $this->sendMail($invitation);

        return $this->createJsonAPiSaveResponse($this->repository->saveInvitation($invitation));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Invitation::class && ($id = $data->getId())):
                return AgentApiResponse::INVITATION_SAVED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}