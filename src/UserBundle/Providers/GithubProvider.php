<?php

namespace UserBundle\Providers;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use UserBundle\Entity\User;

class GithubProvider
{
    /**
     * setUserData - This method use GithubProvider GraphAPI for get and set User data
     *
     * @param  User                  $user
     * @param  UserResponseInterface $response
     * @return User
     */
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $arrResponse = $response->getResponse();
//        dump($arrResponse, $response);exit;

        $userFirstName = strstr($response->getRealName(), ' ', true);
        $userLastName = str_replace(' ', '', strstr($response->getRealName(), ' '));
        // Prepare new User object before adding to database
//        dump($arrResponse);exit;
        $user
            ->setEnabled(true)
            ->setUsername($arrResponse['login'])
            ->setFirstName($arrResponse['name'])
            ->setLastName($arrResponse['name'])
            ->setEmail($arrResponse['email'])

            ->setPassword(md5($response->getAccessToken()))
            ->setAvatar($arrResponse['avatar_url'])
            ->setRoles(array('ROLE_USER'));

//        dump($user);
        return $user;
    }
}
