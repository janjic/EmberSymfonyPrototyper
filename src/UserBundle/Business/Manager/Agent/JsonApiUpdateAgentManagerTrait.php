<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use UserBundle\Business\Event\Agent\AgentEvents;
use UserBundle\Business\Event\Agent\AgentGroupChangeEvent;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiUpdateAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiUpdateAgentManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data)
    {
        /**
         * @var Agent $agent
         */
        $agent = $this->deserializeAgent($data);

        /** @var Agent $dbAgent */
        $dbAgent       = $this->getEntityReference($agent->getId());
        $dbAgentGroup  = $dbAgent->getGroup();
        $dbAgentLocked = $dbAgent->isEnabled();

        $agent = $this->prepareUpdate($agent, $dbAgent, $data);
        $dbSuperior = $dbAgent->getSuperior();
        $newSuperior = null;

        if(!is_null($agent->getSuperior())){
            $newSuperior  = $this->getEntityReference($agent->getSuperior()->getId());
            $agent->setSuperior($newSuperior);
        }
        $agentOrException = $this->edit($dbAgent, $dbSuperior, $newSuperior);

        if ($agentOrException instanceof Exception) {
            !is_null($image = $agent->getImage()) ? $image->deleteFile() : false;
        } else {
            $changeGroup     = null;
            $changeSuspended = null;

            /** is there a change in group */
            if ($dbAgentGroup->getId() !== $agentOrException->getGroup()->getId()) {
                $changeGroup = $dbAgentGroup;
            }
            /** is there a change in status */
            if ($dbAgentLocked !== $agentOrException->isEnabled()) {
                $changeSuspended = $agentOrException->isEnabled();
            }
            /** if there are changes record them */
            if ($changeGroup !== null || $changeSuspended !== null) {
                $event = new AgentGroupChangeEvent($agentOrException, $changeGroup, $changeSuspended);
                $this->eventDispatcher->dispatch(AgentEvents::ON_AGENT_GROUP_CHANGE, $event);
            }

            try {
                $syncResult = $this->syncWithTCRPortal($agent, 'edit');
                if (is_object($syncResult) && $syncResult->code == 200) {
                    $this->flushDb();
                } else {
                    return new ArrayCollection(AgentApiResponse::AGENT_SYNC_ERROR_RESPONSE);
                }
            } catch (\Exception $exception) {
                return new ArrayCollection(AgentApiResponse::AGENT_SYNC_ERROR_RESPONSE);
            }
        }

        return $this->createJsonAPiUpdateResponse($agentOrException);
    }


    private function prepareUpdate(Agent $agent, Agent $dbAgent, $data)
    {
        AgentSerializerInfo::updateBasicFields($agent, $dbAgent);
        $this->setAndValidatePassword($agent, $dbAgent, $data);
        $this->setAndvalidateAddress($agent, $dbAgent);
        $this->setAndValidateGroup($agent, $dbAgent);
        $this->setAndValidateImage($agent, $dbAgent);


        return $agent;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiUpdateResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                var_dump($data->getMessage());die();
                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
            case (Agent::class && ($id= $data->getId())):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_SUCCESSFULLY($id));
            case (Agent::class && !($id= $data->getId()) && $data->getImage()):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_FILE_FAILED_RESPONSE);
            default:
                return false;
        }
    }

    /**
     * @param Agent $agent
     * @param Agent $dbAgent
     * @param $data
     */
    private function setAndValidatePassword (Agent $agent, Agent $dbAgent, $data)
    {

        if (!is_null($agent->getPlainPassword())) {
            $decoded = $decoded = (array)json_decode($data,true);
            $agent->setPropertyValue('passwordRepeat',$decoded['data']['attributes']['passwordRepeat']);
            if (($agent->getPlainPassword() === $agent->getPropertyValue('passwordRepeat')) ) {
                $dbAgent->setPlainPassword($agent->getPlainPassword());
            }

        }


    }

    private function setAndValidateAddress (Agent $agent, Agent $dbAgent)
    {
        $dbAddress = $dbAgent->getAddress();
        if ($dbAddress) {
            $agent->getAddress()?$agent->getAddress()->setId($dbAddress->getId()) : false;
        }
        $dbAgent->setAddress($agent->getAddress());


    }

    private function setAndValidateGroup (Agent $agent, Agent $dbAgent)
    {
        $agent->getGroup() ? ($dbGroup = $this->groupManager->getReference($agent->getGroup()->getId()))&& $dbAgent->setGroup($dbGroup):false;
       ;

    }



    /**
     * @param Agent $agent
     * @param Agent $dbAgent
     */
    private function setAndValidateImage (Agent $agent, Agent $dbAgent)
    {
        /**
         * @var Image $dbImage
         */
        //AGENT ALREADY HAVE IMAGE
        if ($dbImage = $dbAgent->getImage()) {
            //Agent not have image, we must delete old image from file and DB
            if (is_null($agent->getImage())) {
                ($img = $dbAgent->getImage()) ? $img->deleteFile() :false;
                $dbAgent->setImage(null);
                $dbAgent->setBaseImageUrl(null);
                //Agent changed his/her image, we must only update image
            } else if ($agent->getImage()->getId() && !$agent->getImage()->getWebPath()) {
                $dbImage->setBase64Content($agent->getImage()->getBase64Content());
                $dbImage->deleteFile();
                $this->saveMedia($dbAgent);
            }
            //DB AGENT IS WITHOUT IMAGE, we must add new
        } else {
            $dbAgent->setImage($agent->getImage());
            $this->saveMedia($agent);
        }

    }




}