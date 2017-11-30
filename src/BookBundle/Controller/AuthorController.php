<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use BookBundle\Entity\Author;

class AuthorController extends Controller
{

	/**
	* @Route("/listAuthors", name="authors_list")
	*/
	public function getAllAction()
	{
		$authors = $this->getDoctrine()->getRepository('BookBundle:Author')->findAll();
		$data = $this->get('jms_serializer')->serialize($authors, 'json');

		$response = new Response($data);

		return $response;
	}

	/**
	* @Route("/author/{id}", name="get_author")
	*/
	public function getAction(Author $author)
	{
		$author = $this->get('jms_serializer')->serialize($author, 'json');
		$response = new Response($author);

		return $response;
	}


	/**
	* @Route("/addAuthor", name="add_author")
    * @Method({"POST"})
	*/
	public function createAction(Request $request)
	{	
		$data = $request->getContent();
		$author = $this->get('jms_serializer')->deserialize($data, 'BookBundle\Entity\Author' ,'json');

		$em = $this->getDoctrine()->getManager();
		$em->persist($author);
		$em->flush();

		return new Response('', Response::HTTP_CREATED);
	}

	/**
	* @Route("/deleteAuthor/{id}", name="delete_author")
    * @Method({"DELETE"})
	*/
	public function deleteAction(Author $author)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($author);
		$em->flush();

		$response = new Response('auteur supprimé');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');

		return $response;
	}
}
