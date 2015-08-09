<?php

namespace ProfileBundle\Controller;

use ProfileBundle\Form\DeveloperAvatarType;
use ProfileBundle\Form\DeveloperPersonalInformationType;
use ProfileBundle\Form\DeveloperProfessionalSkillsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProfileBundle\Form\DeveloperAllCvType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class DeveloperProfileController extends Controller
{
    protected $template = 'Developer';

    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $developer = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        if (! $developer) {
            throw $this->createNotFoundException('Unable to find a profile.');
        }

        $formType = new DeveloperPersonalInformationType();
        $form = $this->createForm($formType, $developer);
        $personalInformationForm = $form->createView();

        $formType = new DeveloperProfessionalSkillsType();
        $form = $this->createForm($formType, $developer);
        $professionalSkillsForm = $form->createView();

        $all_cv = $this->createForm(new DeveloperAllCvType());

        return $this->render('ProfileBundle:'.$this->template.':index.html.twig',array(
            'developer' => $developer,
            'infoForm' => $personalInformationForm,
            'skillsForm' => $professionalSkillsForm,
            "AllCv" => $all_cv->createView(),
        ));
    }

    public function submitPersonalInformationAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $developer = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        if (! $developer) {
            throw $this->createNotFoundException('Unable to find a profile.');
        }

        $form = $this->createForm(new DeveloperPersonalInformationType(), $developer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profile_homepage', array('slug' => $slug)).'#personal-information');
        }

        $response = $this->render('ProfileBundle:'.$this->template.':form_personal_information.html.html.twig',array(
            'form' => $form->createView(),
            'developer' => $developer
        ));

        return $response;
    }

    public function submitProfessionalSkillsAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $developer = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        if (! $developer) {
            throw $this->createNotFoundException('Unable to find a profile.');
        }

        $form = $this->createForm(new DeveloperProfessionalSkillsType(), $developer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profile_homepage', array('slug' => $slug)).'#professional-skills');
        }

        $response = $this->render('ProfileBundle:'.$this->template.':form_professional_skills.html.twig',array(
            'form' => $form->createView(),
            'developer' => $developer
        ));

        return $response;
    }

    public function photoUploadAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $developer = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        $url = sprintf(
            '%s%s',
            $this->container->getParameter('acme_storage.amazon_s3.base_url'),
            $this->getPhotoUploader()->upload($request->files->get('file'))
        );
//        dump($url);exit;
        $developer->setAvatar($url);
        $em->persist($developer);

        $em->flush();

        return new Response($url);
    }

    public function cvUploadAllAction($slug)
    {

        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $developer = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        if (! $developer) {
            throw $this->createNotFoundException('Unable to find a profile.');
        }

        $cv = $developer->getCvDirUri();

        if ($cv && file_exists($cv)) {
            unlink($cv);
        }

        $form = $this->createForm(new DeveloperAllCvType(), array());

        if ($request->isMethod('POST')) {

            $form->bind($request);
            if ($form->isValid()) {

                $data = $form->getData();

                $uploader = $this->get('profile.file_uploader');
                $path = $uploader->uploadFile($data['photo']);
                $developer->setCvDirUri($path['url']);

                $content = shell_exec('/usr/bin/antiword '.'chmod o+r /var/www/aog-code/web/'.$path['url']);

//                $content = $this ->get('parse_all')->parse('/var/www/aog-code/web/'.$path['url'], $data['photo']->getClientMimeType());


                if ($data['photo']->getClientMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
//                    dump('/var/www/aog-code/web/'.$path['url']);exit;
                    $content = $this->get('parse_docx')->read_file_docx('/var/www/aog-code/web/'.$path['url']);

                } elseif ($data['photo']->getClientMimeType() == 'application/pdf') {

                    $content = $this->get('parse_pdf')->parse('/var/www/aog-code/web/'.$path['url']);

                } else {
                    $content = $this->get('parse_doc')->parse('/var/www/aog-code/web/'.$path['url']);

                }

                $url = sprintf(
                    '%s%s',
                    $this->container->getParameter('acme_storage.amazon_s3.base_url'),
                    $this->getPhotoUploader()->uploadFromUrl($path['url'])
                );

                $developer->setTextCv($content);
                $developer->setCvUri($url);

                $em->flush();

                return $this->redirect($this->generateUrl('profile_homepage', array('slug' => $slug)).'#cv');
            }
        }

        return array(
            "form" => $form->createView(),
        );

    }

    /**
     * @return \StorageBundle\Upload\PhotoUploader
     */
    protected function getPhotoUploader()
    {
        return $this->get('acme_storage.photo_uploader');
    }
}
