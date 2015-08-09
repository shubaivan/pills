<?php

namespace PillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/get")
 */
class GetController extends Controller
{
    /**
     * @Route("/all", name="get_all_gets")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gets = $em->getRepository('PillsBundle:Get')->findBy([], ['id' => 'DESC']);

        $paginator  = $this->get('knp_paginator');
        $gets = $paginator->paginate(
            $gets,
            $request->query->get('page', 1),
            4
        );

        return [
            'gets'=>$gets,
            'user' => $this->get('user')->getInfo(),
        ];
    }

//    /**
//     * @Route("/by-tag/{tag}", name="get_posts_by_tag")
//     * @Method({"GET"})
//     * @Template()
//     * @param Request $request
//     * @return array
//     */
//    public function findByTagAction(Request $request, $tag)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $tags = $em->getRepository('PillsBundle:Tag')
//            ->getTag($tag);
//
//        $posts = $em->getRepository('PillsBundle:Post')
//            ->getPostByTag($tags);
//
//        $paginator  = $this->get('knp_paginator');
//        $posts = $paginator->paginate(
//            $posts,
//            $request->query->get('page', 1),
//            4
//        );
//
//        return [
//            'posts'=>$posts,
//            'user' => $this->get('user')->getInfo(),
//        ];
//    }
//
//    /**
//     * @Route("/by-category/{category}", name="get_posts_by_category")
//     * @Method({"GET"})
//     * @Template()
//     * @param Request $request
//     * @return array
//     */
//    public function findByCategoryAction(Request $request, $category)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $categorys = $em->getRepository('PillsBundle:Category')
//            ->getCategory($category);
//
//        $posts = $em->getRepository('PillsBundle:Post')
//            ->getPostByCategory($categorys);
//
//        $paginator  = $this->get('knp_paginator');
//        $posts = $paginator->paginate(
//            $posts,
//            $request->query->get('page', 1),
//            4
//        );
//
//        return [
//            'posts'=>$posts,
//            'user' => $this->get('user')->getInfo(),
//        ];
//    }
}
