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




class BookController extends Controller
{

    /**
    * @Route("/book/{id}", name="book_id")
    */
    public function getAction(book $book)
    {
        $books = $this->getDoctrine()->getRepository('BookBundle:book')->findAll();

    	$data = $this->get('jms_serializer')->serialize($book, 'json');
    	$response = new Response($data);

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
    	return $response;
    }

    /**
    * @Route("/addbook", name="add_book")
    * @Method({"POST"})
    */
    public function createAction(request $request)
    {
    	$data = $request->getContent();
    	$book = $this->get('jms_serializer')->deserialize($data, 'BookBundle\Entity\book', 'json');

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($book);
    	$em->flush();

    	return new Response('', Response::HTTP_CREATED);
    }

	  /**
    * @Route("/deleteBook/{id}", name="delete_book")
    * @Method({"DELETE"})
    */
    public function deleteAction(book $book)
    {
    	$em = $this->getDoctrine()->getManager();
    	$em->remove($book);
    	$em->flush();

    	return new Response('deleted');
    }

    /**
    * @Route("/updateBook/{id}", name="edit_book")
    * @Method({"PUT"})
    */
    public function updateAction(Request $request ,$id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$book = $em->getRepository('BookBundle:book')->find($id);
		
		$all = $request->getContent(); 
    	$tab = json_decode($all, true);
    	$title = $tab['title'];
    	$author = $tab['author'];
		$book->setTitle($title)->setAuthor($author);
		$em->flush();

		return new Response($tab);
    }

}
