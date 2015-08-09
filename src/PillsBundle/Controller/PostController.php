<?php

namespace PillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/")
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="get_all_posts")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('PillsBundle:Post')->findBy([], ['id' => 'DESC']);

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            4
        );

        return [
            'posts'=>$posts,
            'user' => $this->get('user')->getInfo(),
        ];
    }
}
