<?php
namespace PillsBundle\Controller;

use PillsBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\DependencyInjection\ContainerInterface,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;
use UserBundle\Entity\User;

/**
 * @Route("/registration")
 */
class RegistrationController extends Controller
{
//    private $emailSubject = ', we have a new project for';
//    private $emailAuthorName = 'Shuba Ivan (Talent Backend Developer)';
//    private $emailFrom = 'tanya@a-og.eu';
//
//
    private $hf, $hm;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        $this->hf = $this->container->get('profile.additional_function');
        $this->hm = $this->container->get('pills.profile.mail_manager');
    }

    /**
     * @Route("/", name="pills_registration")
     * @Method("POST")
     */
    public function regAction(Request $request)
    {
//        dump($request);exit;
        $user = new User();
        $form = $this->createFreelancerForm($user);
        $form->handleRequest($request);

        //$email_to = $this->container->getParameter('admin_mail');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $pass = $this->hf->generatePassword();
//            dump($pass, sha1($pass));exit;
            $user
                ->setUsername($user->getFirstName() . '-' . $user->getLastName())
                ->setPassword(sha1($pass))
                ->setRoles(['ROLE_USER']);
            $em->persist($user);
//            dump($this->hf->isUniqueEmail($user, 'Developers'));exit;
            if ($this->hf->isUniqueEmail($user)) {

                $this->hm->toUser_registration($user, $pass, 'user');

                return $this->redirect($this->generateUrl('get_all_posts'));

            } else {
                $form->addError(new FormError('User with this email is already registered'));
            }
        }

        return $this->render('PillsBundle:Registration:user.html.twig', array('entity' => $user, 'form' => $form->createView()));
    }


    /**
     * @Route("/user", name="pills_registration_freelancer")
     * @Template()
     */
    public function userAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('profile_homepage'));
        }

        $user = new User();
        $form = $this->createFreelancerForm($user);

        /*$em = $this->getDoctrine()->getManager();
        $skills = $em->getRepository('ArtelCustomerBundle:Skills')->findAll();*/

        return array('entity' => $user, 'form' => $form->createView());
    }

    /**
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFreelancerForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('pills_registration'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Register'));

        return $form;
    }
}