<?php

namespace UserBundle\Controller;


use CoreBundle\Adapter\AgentApiCode;
use CoreBundle\Adapter\AgentApiEmberRoute;
use CoreBundle\Adapter\AgentApiEvent;
use CoreBundle\Adapter\AgentApiResponse;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Agent;


class ResettingAgentController extends Controller
{

    /**
     * @Route("/api/agents-forgot-password", name="api_agent_forgot_password", options={"expose" = true}),
     * @param Request $request
     * @return Response
     */
    public function forgotPasswordAction(Request $request)
    {

        $username = $request->request->get('usernameOrPassword');
        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (!$user) {
            return new JsonResponse(AgentApiResponse::USER_WITH_EMAIL_NOT_EXIST_RESPONSE);
        }
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /* Dispatch init event */
        $event = new GetResponseNullableUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $ttl = $this->get('service_container')->getParameter('fos_user.resetting.token_ttl');
        if (null !== $user && !$user->isPasswordRequestNonExpired($ttl)) {
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            if (null === $user->getConfirmationToken()) {
                /** @var $tokenGenerator TokenGeneratorInterface */
                $tokenGenerator = $this->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }

            /* Dispatch confirm event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            $this->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->get('fos_user.user_manager')->updateUser($user);

            /* Dispatch completed event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
        } else {
            return new JsonResponse(AgentApiResponse::PASSWORD_ALREADY_REQUESTED($ttl));
        }

        return new JsonResponse(AgentApiResponse::SUCCESS_MAIL_SENT_RESPONSE);

    }

    /**
     * @Route("/api/agents-reset-password/{token}", name="api_agent_reset_password", options={"expose" = true}),
     * @param Request $request
     * @return Response
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return new JsonResponse(AgentApiResponse::USER_WITH_TOKEN_NOT_EXIST_RESPONSE);
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if (((($pass = $request->request->get('password'))) === ($confirmPass = $request->request->get('passwordConfirmation'))) && $pass && $confirmPass) {
            $user->setPlainPassword($pass);
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setEnabled(true);
            $userManager->updateUser($user);

            /* Dispatch completed event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(AgentApiEvent::RESETTING_APP_EVENT, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            return new JsonResponse(AgentApiResponse::PASSWORDS_CHANGED_OK_RESPONSE($user->getEmail()));
        } else {
            return new JsonResponse(AgentApiResponse::PASSWORDS_ARE_NOT_SAME_RESPONSE);
        }

    }

    /**
     * @param UserInterface $user
     */
    private function sendResettingEmailMessage($user)
    {
        $url = $this->get('request_stack')->getCurrentRequest()->getSchemeAndHttpHost().'/'.AgentApiEmberRoute::ROUTE_AFTER_CHANGED_PASSWORD_IN_MAIL.'/'.$user->getConfirmationToken();
        $context = array(
            'user' => $user,
            'confirmationUrl' => $url,
        );
        $context = $this->get('twig')->mergeGlobals($context);
        $template = $this->get('twig')->loadTemplate($this->get('service_container')->getParameter('fos_user.resetting.email.template'));
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->get('service_container')->getParameter('fos_user.resetting.email.from_email'))
            ->setTo((string) $user->getEmail());

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->get('mailer')->send($message);

    }

    /**
     * @Route("/api/agents-change-password", name="api_agent_change_password", options={"expose" = true}),
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        /* Dispatch completed event */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var UserInterface $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $oldPassword = $request->request->get('oldPassword');

        $encoder =   $this->get('security.encoder_factory')->getEncoder($user);

        if ($encoder->isPasswordValid($user->getPassword(), $oldPassword, $user->getSalt())) {
            if (($newPassword =  $request->request->get('password')) === ($confirmedPassword = $request->request->get('passwordConfirmation'))) {
                $user->setPlainPassword($newPassword);
                $event = new GetResponseUserEvent($user, $request);
                $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

                if (null !== $event->getResponse()) {
                    return $event->getResponse();
                }
                $userManipulator = $this->get('fos_user.util.user_manipulator');
                $userManipulator->changePassword($user->getUsername(), $newPassword);

                $event = new GetResponseUserEvent($user, $request);
                $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, $event);

                if (null !== $event->getResponse()) {
                    return $event->getResponse();
                }
                return new JsonResponse(AgentApiResponse::PASSWORDS_CHANGED_OK_RESPONSE);
            } else {
                return new JsonResponse(AgentApiResponse::PASSWORDS_ARE_NOT_SAME_RESPONSE);
            }
        }

        return new JsonResponse(AgentApiResponse::OLD_PASSWORD_IS_NOT_CORRECT_RESPONSE);

    }


}
