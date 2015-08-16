<?php

namespace PillsBundle\Controller;

use PillsBundle\Entity\Post;
use PillsBundle\Form\Type\PostType;
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

    /**
     * @Route("/by-tag/{tag}", name="get_posts_by_tag")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function findByTagAction(Request $request, $tag)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('PillsBundle:Tag')
            ->getTag($tag);

        $posts = $em->getRepository('PillsBundle:Post')
            ->getPostByTag($tags);

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

    /**
     * @Route("/by-category/{category}", name="get_posts_by_category")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function findByCategoryAction(Request $request, $category)
    {
        $em = $this->getDoctrine()->getManager();

        $categorys = $em->getRepository('PillsBundle:Category')
            ->getCategory($category);

        $posts = $em->getRepository('PillsBundle:Post')
            ->getPostByCategory($categorys);

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            4
        );

        return [
            'posts'=>$posts,
            'category'=> $categorys[0],
            'user' => $this->get('user')->getInfo(),
        ];
    }

    /**
     * @Route("/by-type/{slug}", name="get_posts_by_type")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function findByTypeAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository('PillsBundle:Type')
            ->getType($slug);

        $posts = $em->getRepository('PillsBundle:Post')
            ->getPostByType($type);

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            4
        );

        return [
            'posts'=>$posts,
            'type' => $type[0],
            'user' => $this->get('user')->getInfo(),
        ];
    }


    /**
     * @Route("/addPost", name="add_posts_by_type")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public  function addPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $this->getDoctrine()
            ->getManager()
            ->getRepository('PillsBundle:Tag')
            ->getAllHashTags();

        $post = new Post();

        $form = $this->createForm(new PostType($tags), $post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $url = sprintf(
                '%s%s',
                $this->container->getParameter('acme_storage.amazon_s3.base_url'),
                $this->getPhotoUploader()->uploadUserName($data->getPhoto(), $data->getTitle())
            );
            $post->setPhoto($url);
            $post->setAuthor($this->getUser());

            foreach ($post->getTag() as $value) {
                $value->addPost($post);
            }

            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('get_all_posts'));
        }

        return $this->render('PillsBundle:Post:addPost.html.twig',
            array('post' => $post,
                'form' => $form->createView(),
            ));
    }

    /**
     * @return \StorageBundle\Upload\PhotoUploader
     */
    protected function getPhotoUploader()
    {
        return $this->get('acme_storage.photo_uploader');
    }
}
