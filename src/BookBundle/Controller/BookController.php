<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use BookBundle\Entity\book;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BookController extends Controller
{

    /**
    * @Route("/book/{id}", name="book_id")
    */
    public function getAction(book $book)
    {
    	$data = $this->get('jms_serializer')->serialize($book, 'json');
    	$response = new Response($data);
    	$response->headers->set('Content-Type', 'application-json');

    	return $response;
    }

    /**
    * @Route("/listbook", name="list_book")
    */
    public function getAllAction()
    {
    	$books = $this->getDoctrine()->getRepository('BookBundle:book')->findAll();

    	$data = $this->get('jms_serializer')->serialize($books,'json');

    	$response = new Response($data);
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;
    }



}
