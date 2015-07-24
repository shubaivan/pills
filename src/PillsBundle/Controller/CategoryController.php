<?php

namespace PillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/{slug}", name="get_posts_for_category")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getRepository('PillsBundle:Category');
        $category = $em->findOneBySlug($slug);

        return [
            "category" => $category,
        ];
    }
}
