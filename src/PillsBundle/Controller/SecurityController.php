<?php
namespace PillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/auth")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        $securityContext = $this->container->get('security.context');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_FULLY') ) {
            return $this->redirect($this->generateUrl('get_all_posts'));
        }

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            '_last' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/recovery", name="login_recovery")
     */
    public function passwordRecoveryAction(Request $request)
    {
        $email = $request->get('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $em = $this->getDoctrine()->getManager();
            $arrayEntityName = array('Users' => 'ArtelProfileBundle:Users',
                'Developers' => 'ArtelProfileBundle:Developer' );

            $user = $em->getRepository($arrayEntityName['Users'])->findOneByEmail($email);

            if (empty($user)) {
                $user = $em->getRepository($arrayEntityName['Developers'])->findOneByEmail($email);
                if (empty($user)) {
                    return $this->redirect($this->generateUrl('login_route'));
//                    return new Response('User not registered');
                } else {
                    $typeUser = 'freelancer';
                }
            } else {
                $typeUser = 'freelancer';
            }
            $hf = $this->container->get('artel.profile.additional_function');
            $hm = $this->container->get('artel.profile.mail_manager');
            $pass = $hf->generatePassword();
            $user->setPassword(sha1($pass));

            $em->persist($user);
            $em->flush();

            $hm->toUserPasswordRecovery($user, $pass, 'freelancer');

//            return new Response('1');
            return $this->redirect($this->generateUrl('login_route'));
        } else {
//            return new Response('Enter a valid email address');
            return $this->redirect($this->generateUrl('login_route'));
        }
    }
}