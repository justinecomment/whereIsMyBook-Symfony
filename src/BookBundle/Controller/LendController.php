<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\CorsBundle\NelmioCorsBundle;
use BookBundle\Entity\book;
use BookBundle\Entity\Pret;




class LendController extends Controller
{
	/**
    * @Route("/lendBook/{id}", name="lend_book")
    * @Method({"POST"})
    */
    public function createAction(Request $request)
    {
        $content = $request->getContent();
        $pret = $this->get('jms_serializer')->deserialize($content, 'BookBundle\Entity\Pret', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($pret);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
    * @Route("/listLentBook", name="listLentBook")
    */
    public function getAllAction()
    {
    	$lentBook = $this->getDoctrine()->getRepository('BookBundle:Pret')->findAll();

    	$data = $this->get('jms_serializer')->serialize($lentBook, 'json');

    	return new Response($data);
    }

   
}
