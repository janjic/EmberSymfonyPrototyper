<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
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
        $decoded = $decoded = (array)json_decode($data,true);
        $agent->setPropertyValue('passwordRepeat',$decoded['data']['attributes']['passwordRepeat']);
        /** @var Agent $dbAgent */
        $dbAgent = $this->getEntityReference($agent->getId());
        $agent = $this->prepareUpdate($agent, $dbAgent);
        $dbSuperior = $dbAgent->getSuperior();
        $newSuperior = null;

        if(!is_null($agent->getSuperior())){
            $newSuperior  = $this->getEntityReference($agent->getSuperior()->getId());
            $agent->setSuperior($newSuperior);
        }
        $agentOrException = $this->edit($dbAgent, $dbSuperior, $newSuperior);

        if ($agentOrException instanceof Exception) {
            !is_null($image = $agent->getImage()) ? $image->deleteFile() : false;
        }
        return $this->createJsonAPiUpdateResponse($agentOrException);
//        if($agent->getId()){
//            $this->syncWithTCRPortal($agent, 'edit');
//        }

        //return $agent;
    }


    private function prepareUpdate(Agent $agent, Agent $dbAgent)
    {
        AgentSerializerInfo::updateBasicFields($agent, $dbAgent);
        $this->setAndValidatePassword($agent, $dbAgent);
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
     */
    private function setAndValidatePassword (Agent $agent, Agent $dbAgent)
    {
        if (!is_null($agent->getPlainPassword()) && ($agent->getPlainPassword() === $agent->getPropertyValue('passwordRepeat')) ) {
                $dbAgent->setPlainPassword($agent->getPlainPassword());
        }

    }

    private function setAndValidateAddress (Agent $agent, Agent $dbAgent)
    {
        $dbAddress = $dbAgent->getAddress();
        if ($dbAddress) {
            $agent->getAddress()->setId($dbAddress->getId());
        }
        $dbAgent->setAddress($agent->getAddress());


    }

    private function setAndValidateGroup (Agent $agent, Agent $dbAgent)
    {
        $dbGroup = $this->groupManager->getReference($agent->getGroup()->getId());
        $dbAgent->setGroup($dbGroup);

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
            } else {
               //Nothing to change
            }
            //DB AGENT IS WITHOUT IMAGE, we must add new
        } else {
            $dbAgent->setImage($agent->getImage());
            $this->saveMedia($agent);
        }

    }




}