<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\UpdateProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;

class UserController extends Controller
{
    /**
     * @param  Request                                                  $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function updateContactsAction(Request $request)
    {
        $userAuth = $this->getUser();
//        dump($userAuth);exit;

        if (!$userAuth) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('UserBundle:User')->findOneById($userAuth->getId());

        if (strstr($user->getEmail(),'@example.com')) {
            $user->setEmail('');
        }

        $form = $this->CreateForm(new UpdateProfileType(), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $router = $this->generateUrl("homepage");

            return $this->redirect(
                $router
            );
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
