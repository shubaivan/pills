<?php

namespace UserBundle\Providers;

use Buzz\Message\Request;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use PillsBundle\Entity\Cities;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManager;

class UserProvider extends BaseClass
{
    private $vkontakteProvider;

    private $facebookProvider;

    public $requestStack;
    public $additional_function;
    protected $em;
    public $cityRepository;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, $requestStack, $additional_function, EntityManager $em, $cityRepository, array $properties)
    {
        $this->requestStack = $requestStack;
        $this->additional_function = $additional_function;
        $this->em = $em;
        $this->cityRepository = $cityRepository;
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
//        $ipr = $_SERVER['REMOTE_ADDR'];
//        $ips = $_SERVER['SERVER_ADDR'];
//        dump($ip, $ips);exit;


        $ip = "109.227.72.9";

        $hAid = $this->additional_function;
//                $ip = '176.241.128.140'; //our ip
//                $ip = '192.162.142.150'; //zaporizha
//                $ip = '176.67.18.0'; //kyiv
//                $ip = '158.58.168.79'; //milan
//                $ip = '46.101.34.215'; //london
//                $ip = '62.109.30.190'; //moscow
//                $ip = '5.34.183.81';//harkov
//                $ip = '31.184.242.73';//SPT
//                $ip = '128.101.101.101'; //minissota
//        $ip = $this->requestStack->getCurrentRequest()->getClientIP();
        $record = $hAid->getInfoIpCountry($ip);
        $get_record_city = $hAid->getInfoIpCity($ip);
        $record_country = $record->country->name;

        $city = $this ->addCityAction($get_record_city);
//        dump($record_country, $get_record_city);exit;

//        dump($ip, $ipr, $ips);exit;
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

                $user = $this->$serviceProvider->setUserData($user, $response, $record_country, $city);

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

    public function addCityAction($city)
    {
//        $em = $this->getDoctrine()->getManager();
        $cities = $this->cityRepository->findOneByCity($city);

        if (empty($cities)) {
            $cities = new Cities();
            $cities->setCity($city);
//            $em->persist($cities);
//            $em->flush();
            $this->em->persist($cities);
            $this->em->flush();

            return $cities;
        } else {
            return $cities;
        }

    }

}
