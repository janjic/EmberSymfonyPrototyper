<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Manager\TCRSyncManager;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\Agent;
use UserBundle\Entity\TCRUser;

/**
 * Class TCRUserManager
 * @package UserBundle\Business\Manager
 */
class TCRUserManager extends TCRSyncManager implements JSONAPIEntityManagerInterface
{
    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * TCRUserManager constructor.
     * @param FJsonApiSerializer $fSerializer
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(FJsonApiSerializer $fSerializer, TokenStorageInterface $tokenStorage)
    {
        $this->fSerializer = $fSerializer;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function jqgridAction($request)
    {
        $url = 'en/json/get-jqgrid-user-all?';
        $url.= 'rows='.$request->get('offset');
        $url.= '&page='.$request->get('page');
        $url.= '&sidx='.$request->get('sidx');
        $url.= '&sord='.$request->get('sord');

        if ($filters = json_decode($request->get('filters'), true)) {
            foreach ($filters['rules'] as &$rule) {
                $rule['field'] = $this->changeToTCRFormat($rule['field']);
            }
            $url.= '&_search=true';
            $url.= '&filters='.json_encode($filters);
        }

        /** @var Agent $user */
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user->hasRole('ROLE_ADMIN')){
            $url.= '&agentId='.$user->getAgentId();
        };

        $resp = $this->getContentFromTCR($url);

        $users = array();
        foreach ($resp->items as $user) {
            $new = new TCRUser();
            foreach ($user as $key => $value) {
                $new->setPropertyValue($key, $user->{$key});
            }

            $users[] = $new;
        }

        $meta = [
            'totalItems' => $resp->description->totalCount,
            'pages'      => $resp->description->pageCount,
            'page'       => $resp->description->current
        ];

        return $this->serializeTCRUser($users, $meta);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        var_dump($id);die();
        // TODO: Implement getResource() method.
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveResource($data)
    {
        var_dump('stig');die();
        // TODO: Implement saveResource() method.
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {
        var_dump('stig');die();
        // TODO: Implement updateResource() method.
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id)
    {
        var_dump('stig');die();
        // TODO: Implement deleteResource() method.
    }

    public function serializeTCRUser($user, $meta = null){
        $mappings = array(
            'tcr-users' => array('class' => TCRUser::class, 'type'=>'tcr-users'),
        );

        $serialized = $this->fSerializer->serialize($user, $mappings, []);

        if ($meta) {
            foreach ($meta as $key => $value) {
                $serialized->addMeta($key, $value);
            }
        }

        return $serialized;
    }
}