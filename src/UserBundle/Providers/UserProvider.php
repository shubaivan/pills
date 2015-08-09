<?php

namespace UserBundle\Providers;

use Buzz\Message\Request;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UserProvider extends BaseClass
{
    private $vkontakteProvider;

    private $facebookProvider;

    public $requestStack;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, $requestStack, array $properties)
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
        $this->properties  = array_merge($this->properties, $properties);
        $this->accessor    = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $ips = $_SERVER['SERVER_ADDR'];
//        dump($ip, $ips);exit;

        $ip = $this->requestStack->getCurrentRequest()->getClientIP();
        dump($ip);exit;
//        $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $username = $response->getUsername();
        $email = $response->getEmail();

        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));

        //when the user is registrating
        if (null === $user) {

            $user = $this->userManager->findUserByEmail($email);

            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setterId = $setter . 'Id';
            $setterToken = $setter . 'AccessToken';
            if (null === $user) {
                $user = $this->userManager->createUser();
                $user->$setterId($username);
                $user->$setterToken($response->getAccessToken());

                $serviceProvider = $service."Provider";

                $user = $this->$serviceProvider->setUserData($user, $response);

                $this->userManager->updateUser($user);

                return $user;
            }else {
                $user->$setterId($username);
                $user->$setterToken($response->getAccessToken());

                $serviceProvider = $service."Provider";

                $user = $this->$serviceProvider->setUserData($user, $response);

                $this->userManager->updateUser($user);

                return $user;
            }
        }


        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

    public function setVkontakteProvider(VkontakteProvider $vkontakteProvider)
    {
        $this->vkontakteProvider = $vkontakteProvider;
    }

    public function setFacebookProvider(FacebookProvider $facebookProvider)
    {
        $this->facebookProvider = $facebookProvider;
    }

}
