<?php

namespace UserBundle\Business\Provider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Business\Manager\AgentManager;


/**
 * Class AgentOauthProvider
 * @package UserBundle\Business\Provider
 */
class AgentOauthProvider implements UserProviderInterface
{
    /** @var  AgentManager */
    protected $agentManager;

    /**
     * AgentOauthProvider constructor.
     * @param AgentManager $agentManager
     */
    public function __construct(AgentManager $agentManager)
    {
        $this->agentManager = $agentManager;
    }


    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        return $this->agentManager->loadUserForProvider($username);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->agentManager->refreshUserForProvider($user);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}