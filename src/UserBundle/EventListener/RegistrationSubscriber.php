<?php

namespace UserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Router;
use UserBundle\Entity\User;

class RegistrationSubscriber
{
    const UPDATE_CONTACTS_ROUTE = 'user_update_profile';

    protected $ignoredPrefixRoutes = ['connect', 'login-social', 'connect-account', 'upload'];
    protected $container;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $path = explode('/', $this->container->get('router')->getContext()->getPathInfo());

        if (in_array($path[1], $this->ignoredPrefixRoutes)) {
            return;
        }

        $user = $this->getUser();

        if (!($user instanceof User)) {
            return;
        }

        $request = $this->container->get('request');
        $updateContactsAction = $this->container->get('router')->generate(self::UPDATE_CONTACTS_ROUTE, array(), Router::ABSOLUTE_URL);

        if ($user->isFakeUsername() && $request->get('_route') !== self::UPDATE_CONTACTS_ROUTE) {
            $event->setResponse(new RedirectResponse($updateContactsAction));
        }

        if ($user->isFakeEmail() && $request->get('_route') !== self::UPDATE_CONTACTS_ROUTE) {
            $event->setResponse(new RedirectResponse($updateContactsAction));
        }
    }

    public function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}
