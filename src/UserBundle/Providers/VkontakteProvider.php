<?php

namespace UserBundle\Providers;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use UserBundle\Entity\User;
/**
 * Class VkontakteProvider
 * @package UserBundle\Providers
 */
class VkontakteProvider
{
    // Declaration of constants for various types genders of user
    const GENDER_MALE      = 'Male';
    const GENDER_FAMILY    = 'Family';
    const GENDER_UNDEFINED = 'Undefined';
    /**
     * This method for getting user data from API and setting him
     * to Doctrine2 object before data persist and flush in database
     *
     * @param User $user
     * @param UserResponseInterface $response
     * @return User
     */
    public function setUserData(User $user, UserResponseInterface $response)
    {
        // Get response from API server
        $responseArray = $response->getResponse();
//        dump($response, $responseArray);exit;
        // Get user data from response with Vkontakte API v5.30
        $userAvatar = $responseArray['response'][0]['photo_200'];

        if (!$responseArray['response'][0]['skype'])
        {
            $userSkype = $responseArray['response'][0]['skype'];
            $user->setSkype($userSkype);
        }


        $userFirstName = $responseArray['response'][0]['first_name'];
        $userLastName = $responseArray['response'][0]['last_name'];
        $userDomain = $responseArray['response'][0]['domain'];
        $userGender = $responseArray['response'][0]['sex'];
        $userEmail = $response->getEmail();
        if (!$userGender || $userGender == 0) {
            $userGender = VkontakteProvider::GENDER_UNDEFINED;
        }
        if ($userGender == 1) {
            $userGender = VkontakteProvider::GENDER_FAMILY;
        }
        if ($userGender == 2) {
            $userGender = VkontakteProvider::GENDER_MALE;
        }
        if (!$userEmail) {
            $userEmail = 'example@mail.com';
        }
        // Prepare new User object before adding to database
        $user
            ->setEnabled(true)
//            ->setSkype($userSkype)
            ->setUsername($userFirstName.' '.$userLastName)
            ->setFirstName($userFirstName)
            ->setLastName($userLastName)
            ->setEmail($userEmail)
            ->setSocialNetworkUrl('http://vk.com/' . $userDomain)
            ->setPassword(md5($response->getAccessToken()))
            ->setAvatar($userAvatar)
            ->setGender($userGender)
            ->setSocialNetworkName('vkontakte')
            ->setRoles(array('ROLE_USER'));
        return $user;
    }
}