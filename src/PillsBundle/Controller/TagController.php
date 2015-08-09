<?php

namespace PillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/tag")
 */
class TagController extends Controller
{

    /**
     * @Route("/{slug}", name="get_posts_for_tags")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getRepository('PillsBundle:Tag');
        $tag = $em->findOneByHashSlug($slug);

        return [
            "tag" => $tag,
        ];
    }

    /**
     * @Route("/topTags")
     * @Method({"GET"})
     * @Template()
     */
    public function topTagsAction()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository('PillsBundle:Tag')->findTopTags();

        return [
            "tags" => $tags
        ];
    }
}