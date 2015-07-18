<?php

namespace UserBundle\Providers;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use UserBundle\Entity\User;

class LinkedinProvider
{
    /**
     * setUserData - This method use Linkedin GraphAPI for get and set User data
     *
     * @param  User                  $user
     * @param  UserResponseInterface $response
     * @return User
     */
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $arrResponse = $response->getResponse();

        $userFirstName = strstr($response->getRealName(), ' ', true);
        $userLastName = str_replace(' ', '', strstr($response->getRealName(), ' '));
        // Prepare new User object before adding to database
//        dump($arrResponse, $response);exit;
        $user
            ->setEnabled(true)
            ->setUsername($userFirstName)
            ->setFirstName($userFirstName)
            ->setLastName($userLastName)
            ->setEmail($response->getEmail())

            ->setPassword(md5($response->getAccessToken()))
            ->setAvatar($response->getProfilePicture())
            ->setRoles(array('ROLE_USER'));

//        dump($user);exit;
        return $user;
    }
}
