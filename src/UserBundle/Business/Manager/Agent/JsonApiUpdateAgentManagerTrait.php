<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use UserBundle\Business\Event\Agent\AgentEvents;
use UserBundle\Business\Event\Agent\AgentGroupChangeEvent;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Helpers\RoleHelper;

/**
 * Class JsonApiUpdateAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiUpdateAgentManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data, $isPromotionEdit = false)
    {

        if(!$isPromotionEdit){
            /**
             * @var Agent $agent
             */
            $agent = $this->deserializeAgent($data);
        } else {
            /**
             * @var Agent $agent
             */
            $agent = $data;
        }

        if ($agent->getImage() && $agent->getImage()->getId() ===0){
            $agent->getImage()->setId(null);
        }
        /** @var Agent $dbAgent */
        $dbAgent       = $this->getEntityReference($agent->getId());
        $dbAgentGroup  = $dbAgent->getGroup();
        $dbAgentLocked = $dbAgent->isEnabled();

        $activeAgentsNumb = 0;
        if($array = $dbAgent->getActiveAgentsIds()){
            $activeAgentsNumb = sizeof($array);
        }
        $numbOfSales = $dbAgent->getPaymentsNumb();
        $newSuperior = null;

        if(!is_null($agent->getSuperior()) && !$isPromotionEdit){
            $newSuperior  = $this->getEntityReference($agent->getSuperior()->getId());
            $agent->setSuperior($newSuperior);
        }

        $agent = $this->prepareUpdate($agent, $dbAgent, $data);
        $dbSuperior = $dbAgent->getSuperior();

//        if(!is_null($agent->getSuperior()) && !$isPromotionEdit){
//            $newSuperior  = $this->getEntityReference($agent->getSuperior()->getId());
//            $agent->setSuperior($newSuperior);
//        }

        if ( !is_null($agent->getNewSuperiorId()) ){
            // Change child agents to new Superior agent
            $refSuperior = $this->getEntityReference($agent->getNewSuperiorId());
            $resp = $this->repository->changeSuperiorOfAllChildren($dbAgent, $refSuperior);
//            var_dump($resp);die();
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
                $event = new AgentGroupChangeEvent($agentOrException, $changeGroup, $changeSuspended, $activeAgentsNumb, $numbOfSales);
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
        $this->setAndValidateAddress($agent, $dbAgent);
        $this->setAndValidateGroup($agent, $dbAgent);
        $this->setAndValidateImage($agent, $dbAgent);
        $this->setAndValidateNotifications($agent, $dbAgent);

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
        $newAddress = $agent->getAddress();
        if (!$dbAddress) {
            $dbAddress = new Address();
        }

        if ($newAddress) {
            $dbAddress->setCity($newAddress->getCity());
            $dbAddress->setCountry($newAddress->getCountry());
            $dbAddress->setFixedPhone($newAddress->getFixedPhone());
            $dbAddress->setPhone($newAddress->getPhone());
            $dbAddress->setPostcode($newAddress->getPostcode());
            $dbAddress->setStreetNumber($newAddress->getStreetNumber());
        }
    }


    private function setAndValidateGroup (Agent $agent, Agent $dbAgent)
    {

//        $agent->getGroup() ? ($dbGroup = $this->groupManager->getReference($agent->getGroup()->getId()))&& $dbAgent->setGroup($dbGroup):false;
            if( $agent->getGroup() ){
                $dbGroup = $this->groupManager->getReference($agent->getGroup()->getId());

                if( $agent->getGroup()->getId() != $dbAgent->getGroup()->getId() ){
                    $dbAgent->setRoleChangedAt(new \DateTime());
                    $dbAgent->setPaymentsNumb(0);
                }
                if(($agent->getGroup()->getName() === RoleHelper::MASTER || $agent->getGroup()->getName() === RoleHelper::ACTIVE) && $agent->getSuperior()->getId() === $dbAgent->getSuperior()->getId()
                    && ($agent->getSuperior() && $agent->getSuperior()->getGroup()->getName() === RoleHelper::MASTER)){
                } else {
                    $superior = $dbAgent->getSuperior();
                    if(!is_null($superior)){
                        $superior->removeFromActiveAgents($agent->getId());
                        $newSuperior = $agent->getSuperior();
                        if($newSuperior->getId() !== $superior->getId() && ($newSuperior->getGroup()->getName() === RoleHelper::MASTER || $newSuperior->getGroup()->getName() === RoleHelper::ACTIVE ) && $agent->getGroup()->getId() === $dbAgent->getGroup()->getId() ){
                            $newSuperior->addActiveAgentId($agent->getId());
                            $this->repository->simpleEdit(array($superior, $newSuperior));
                        } else {
                            $this->repository->simpleEdit(array($superior));
                        }
                    }

                }

                $dbAgent->setGroup($dbGroup);
            }
    }

    private function setAndValidateNotifications (Agent $agent, Agent $dbAgent)
    {
        $dbAgent->setNotifications($agent->getNotifications());
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
            } else if ($agent->getImage()->getId() && $agent->getImage()->getBase64Content()) {
                $dbAgent->getImage()->setName($dbAgent->getImage()->getName().uniqid());
                $dbImage->setBase64Content($agent->getImage()->getBase64Content());
                $dbImage->deleteFile();
                $this->saveMedia($dbAgent);
            }
            //DB AGENT IS WITHOUT IMAGE, we must add new
        } else {
            $dbAgent->setImage($agent->getImage());
            $this->saveMedia($agent);
            $dbAgent->setBaseImageUrl($agent->getBaseImageUrl());
        }

    }




}