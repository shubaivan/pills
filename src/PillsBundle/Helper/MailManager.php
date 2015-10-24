<?php

namespace PillsBundle\Helper;

use UserBundle\Entity\User;
use Hip\MandrillBundle\Message;

class MailManager
{
    const FROM_EMAIL = 'noreply@a-og.eu';
    const TO_EMAIL = 'join@a-og.eu';
    const DEFAULT_SUBJECT = 'Artel Outsourcing Group';
    const ADMIN_EMAIL = 'vg@a-og.eu';

    protected $_templateEngine;
    protected  $hip_mandrill_dispatcher;
    private $adminEmails;
    private $adminMail;

    public function __construct($_templateEngine, $hip_mandrill_dispatcher)
    {
        $this->templateEngine = $_templateEngine;
        $this->hip_mandrill_dispatcher = $hip_mandrill_dispatcher;
    }

    public function setAdminEmails($email_to)
    {
        $this->adminEmails = explode(',', $email_to);
    }

    public function setAdminEmail($email_to)
    {
        $this->adminMail =  $email_to;
    }

    public function sendEmailTpl($tplName, $parameters, $subject = self::DEFAULT_SUBJECT, $to = self::TO_EMAIL, $from = self::FROM_EMAIL)
    {
//        dump($tplName, $parameters, $subject = self::DEFAULT_SUBJECT, $to = self::TO_EMAIL, $from = self::FROM_EMAIL);exit;

        $message = new Message();
        $message
            ->setSubject($subject)
            ->setFromEmail($from)
            ->addTo($to)
//            ->setContentType('text/html')
            ->setHtml($this->templateEngine->render('PillsBundle:Mail:' . $tplName . '.html.twig', $parameters));
//        dump($message, $to);exit;
//        $this->mailer->send($message);
        $this->hip_mandrill_dispatcher->send($message);
//        mail($to, $subject, '', $message);
    }

    public function sendEmail($body, $subject = self::DEFAULT_SUBJECT, $to = self::TO_EMAIL, $from = self::FROM_EMAIL)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setContentType('text/html')
            ->setBody($body);

        mail('', $subject, '', $message);
    }

    // ---------------------------------- Admin Loop ---------------------------------

    public function sendToAllAdminTpl($tplName, $parameters = array(), $subject = self::DEFAULT_SUBJECT, $from = self::FROM_EMAIL)
    {
        foreach ($this->adminEmails as $email)
            $this->sendEmailTpl($tplName, $parameters, $subject, $email, $from);
    }

    public function sendToAllAdmin($body, $subject = self::DEFAULT_SUBJECT, $from = self::FROM_EMAIL)
    {
        foreach ($this->adminEmails as $email)
            $this->sendEmail($body, $subject, $email, $from);
    }

    // -------------------------------- Send To Admin --------------------------------


    public function toAdmin_addDeveloper($text)
    {
        $this->sendToAllAdmin($text, 'Artel Outsourcing Group Add Developers');
    }

    public function toAdmin_requestCoders24h($text)
    {
        $this->sendToAllAdmin($text, 'Artel Outsourcing Request Coders 24h');
    }

    public function toAdmin_registration($text)
    {
        $this->sendToAllAdmin($text, ' A-OG, New Request');
    }

    public function toAdmin_registrationClient($user)
    {
        $this->sendToAllAdminTpl('registration_client', array('user' => $user), self::DEFAULT_SUBJECT . ' Registration Client');
    }

    public function toAdmin_registrationCompany($user)
    {
        $this->sendToAllAdminTpl('registration_client', array('user' => $user), 'A-OG, New company added');
    }

    public function toAdmin_projectAdd($project)
    {
        $this->sendToAllAdminTpl('project_add', array('project' => $project), self::DEFAULT_SUBJECT . ' Add Project');
    }

    public function toAdmin_createVote($vote, $developer, $client)
    {
        $this->sendToAllAdminTpl('create_vote', array('vote' => $vote, 'developer' => $developer, 'client' => $client), self::DEFAULT_SUBJECT . ' Add vote rating developer');
    }

    public function toAdmin_updateVote($vote, $developer, $client)
    {
        $this->sendToAllAdminTpl('update_vote', array('vote' => $vote, 'developer' => $developer, 'client' => $client), self::DEFAULT_SUBJECT . ' Update vote rating developer');
    }

    public function toAdmin_createFeedback($feedback, $developer, $user)
    {
        $this->sendToAllAdminTpl('create_feedback', array('feedback' => $feedback, 'developer' => $developer, 'user' => $user), self::DEFAULT_SUBJECT . ' Update vote rating developer');
    }

    public function toAdmin_hireDev($dev)
    {
        $this->sendToAllAdminTpl('hire_dev', array('dev' => $dev), self::DEFAULT_SUBJECT . ' On Hire');
    }

    public function toAdmin_sendDev($developers, $customer, $project)
    {
        $this->sendToAllAdminTpl('email',
            array('developers' => $developers, 'customerName' => $customer->getUsername(), 'project' => $project),
            self::DEFAULT_SUBJECT . ' On Hire');
    }

    public function toAdmin_freelancerGetProject($project, $user)
    {
        $this->sendToAllAdminTpl('freelance_getProject', array('project' => $project, 'user' => $user), 'A-OG, New Project added');
    }

    public function toAdmin_registrationCoders24_mobile($user, $steps, $infoUser, $developer = '')
    {
        $this->sendToAllAdminTpl('registration_coders24_mobile_admin', array('user' => $user, 'steps' => $steps, 'infoUser' => $infoUser, 'developer' => $developer ),
            'A-OG, new request, mobile version');

        $this->sendEmailTpl('registration_coders24_mobile', array('user' => $user),
            "Meeting Schedule, AOG", $this->adminMail);
    }

    public function toAdmin_registrationCoders24_mobile_xamarin($user, $infoUser, $developer = '')
    {
         $this->sendToAllAdminTpl('registration_coders24_mobile_admin', array('user' => $user, 'steps' => '', 'infoUser' => $infoUser, 'developer' => $developer),
            'A-OG, Xamarin page request');

         $this->sendEmailTpl('registration_coders24_mobile', array('user' => $user),
            "Meeting Schedule, AOG", $this->adminMail);
    }

    public function toAdmin_registrationCoders24($user, $infoUser)
    {
        $this->sendToAllAdminTpl('registration_coders24_admin', array('user' => $user, 'infoUser' => $infoUser),
            self::DEFAULT_SUBJECT . 'Coders24 registration');
    }
    public function toAdmin_notSynchronizeBitrix($params)
    {
        $this->sendToAllAdminTpl('notSynchronizeBitrix', array('params' => $params),
            self::DEFAULT_SUBJECT . 'Not Synchronize Bitrix');
    }
    // -------------------------------- Send To User --------------------------------

    public function toUser_registration($user, $pass, $type)
    {
//        dump($user, $pass, $user->getEmail(), $type);exit;
//        dump('start',
//            array('user' => $user, 'pass' => $pass, 'type' => $type),
//            self::DEFAULT_SUBJECT . ' Registration', $user->getEmail(),
//            'AOG_Access@a-og.eu');exit;
        $this->sendEmailTpl('start',
            array('user' => $user, 'pass' => $pass, 'type' => $type),
            self::DEFAULT_SUBJECT . ' Registration', $user->getEmail(),
            'AOG_Access@a-og.eu');

    }

    public function toUserPasswordRecovery(User $user, $pass, $type)
    {
        $this->sendEmailTpl('password_recovery',
            array('user' => $user, 'pass' => $pass, 'type' => $type),
            self::DEFAULT_SUBJECT . ' Password Recovery', $user->getEmail(),
            'AOG_Access@a-og.eu');
    }

    public function toAdminNewTempUserRegister($user, $type)
    {
        $this->sendEmailTpl('newUser',
            array('user' => $user, 'email' => $user['email'], 'company' => $type),
            self::DEFAULT_SUBJECT . 'Add new temp user ', self::ADMIN_EMAIL,
            self::FROM_EMAIL
        );
    }

    public function toUser_registrationCoders24($user)
    {
        $this->sendEmailTpl('registration_coders24',
            array('user' => $user),
            "Thank you for your request, A-OG", $user->getEmail(),
            'vg@a-og.eu');
    }

    public function toUser_registrationCoders24_mobile($user)
    {
        $this->sendEmailTpl('registration_coders24_mobile',
            array('user' => $user),
            "Meeting Schedule, AOG", $user->getEmail(),
            'vg@a-og.eu');
    }

    public function toAdmin_find_one_field_not_freelance($user)
    {
//        $dispatcher = $this->get('hip_mandrill.dispatcher');
        $message = new Message();

        $message->setFromEmail('noreply@a-og.eu')
            ->addTo($this->adminMail)
            ->setSubject('Title')
            ->setHtml($this->templateEngine->render('ArtelSiteBundle:Mail:find_by_error_role.html.twig', array(
                'user' => $user,
                'role' => $user->getRole()
            )));

        $this->hip_mandrill_dispatcher->send($message);
        return $user;
    }

    public function toAdmin_create_newuser($user, $ref)
    {
        $message = new Message();

        $message->setFromEmail('noreply@a-og.eu')
            ->addTo($this->adminMail)
            ->setSubject('Title')
            ->setHtml($this->templateEngine->render('ArtelSiteBundle:Mail:create_new_user.html.twig', array(
                'user' => $user,
                'codeuserreference' => $ref
            )));

        $this->hip_mandrill_dispatcher->send($message);
        return $user;
    }

    public function toAdmin_twofields_in_twouser($user, $anduser, $template)
    {
        $message = new Message();
        //tel adinistrator fix this problem
        $message->setFromEmail('noreply@a-og.eu')
            ->addTo($this->adminMail)
            ->setSubject('Title')
            ->setHtml($this->templateEngine->render('ArtelSiteBundle:Mail:find_twofields_two_user.html.twig', array(
                'user' => $user,
                'anduser' => $anduser,
                'template' => $template,
            )));

        $this->hip_mandrill_dispatcher->send($message);
        return $user;
    }

    public function toAdmin_find_onefield($user, $template, $request_reference)
    {
        $message = new Message();

        $message->setFromEmail('noreply@a-og.eu')
            ->addTo($this->adminMail)
            ->setSubject('Title')
            ->setHtml($this->templateEngine->render('ArtelSiteBundle:Mail:find_by_one_field.html.twig', array(
                'user' => $user,
                'template' => $template,
                'reference' => $request_reference,
            )));

        $this->hip_mandrill_dispatcher->send($message);
        return $user;
    }

    public function toAdmin_find_twofield($user, $anduser, $template, $request_reference)
    {
        $message = new Message();

        $message->setFromEmail('noreply@a-og.eu')
            ->addTo($this->adminMail)
            ->setSubject('Title')
            ->setHtml($this->templateEngine->render('ArtelSiteBundle:Mail:find_two_fields.html.twig', array(
                'user' => $user,
                'anduser' => $anduser,
                'template' => $template,
                'reference' => $request_reference,
            )));

        $this->hip_mandrill_dispatcher->send($message);
        return $user;
    }
}
