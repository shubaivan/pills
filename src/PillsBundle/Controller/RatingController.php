<?php

namespace PillsBundle\Controller;

use PillsBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 * @Route("/rating")
 */
class RatingController extends Controller
{
    /**
     * @Route("/{slug}", name="click_like")
     * @Method({"POST", "GET"})
     */
    public function addRatingAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('PillsBundle:Post')
            ->findOneBySlug($slug);
        //array rating by post
        $ratings = $em->getRepository('PillsBundle:Rating')
            ->getRatingByPost($post);
//        dump($ratings);exit;

        $rating = new Rating();

        $rating
            ->setUser($this->getUser())
            ->setPost($post)
        ;

        $em->persist($rating);
        $em->flush();

        $all_raiting = array();
//            dump($developer);exit;
        for ($i = 0; $i < count($post->getRatings()); $i++) {
            $all_raiting[$i]["author"] = $post->getRatings()[$i]->getUser()->getFirstName();
            $all_raiting[$i]["createdAt"] = $post->getRatings()[$i]->getCreatedAt()->format("d.m.Y H:i:s");
        }
//        dump(count($all_raiting));exit;
        return new JsonResponse(count($all_raiting));

    }
}