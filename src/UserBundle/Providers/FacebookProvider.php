<?php

namespace UserBundle\Providers;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use UserBundle\Entity\User;

class FacebookProvider
{
    /**
     * setUserData - This method use Facebook GraphAPI for get and set User data
     *
     * @param  User                  $user
     * @param  UserResponseInterface $response
     * @return User
     */
    public function setUserData(User $user, UserResponseInterface $response,  $country, $city)
    {

        $arrResponse = $response->getResponse();
        $responseArray = $response->getResponse();

//        dump($arrResponse);exit;

        $userFirstName = strstr($response->getRealName(), ' ', true);
        $userLastName = str_replace(' ', '', strstr($response->getRealName(), ' '));
        // Prepare new User object before adding to database

        $user
            ->setEnabled(true)
            ->setCountry($country)
            ->setCity($city)
            ->setUsername($response->getNickname())
            ->setFirstName($responseArray['first_name'])
            ->setLastName($responseArray['last_name'])
            ->setEmail($response->getEmail())
            ->setSocialNetworkUrl($arrResponse['link'])
            ->setGender($arrResponse['gender'])
            ->setPassword(md5($response->getAccessToken()))
            ->setAvatar('http://graph.facebook.com/' . $response->getUsername() . '/picture?width=250&height=250')
            ->setRoles(array('ROLE_USER'));

        return $user;
    }
}
