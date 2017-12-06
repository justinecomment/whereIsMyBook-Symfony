<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\CorsBundle\NelmioCorsBundle;
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

		return new Response($data);
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

		return new Response('added', Response::HTTP_CREATED);
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

		return new Response('deleted');
	}

	/**
	* @Route("/updateAuthor/{id}", name="update_author")
    * @Method({"PUT"})
	*/
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$author = $em->getRepository('BookBundle:Author')->find($id);

		$content = $request->getContent();
		$data = json_decode($content, true);
		
		$nom = $data['nom'];
		$prenom = $data['prenom'];
		$nationalite = $data['nationalite'];
		$vivant = $data['vivant'];

		$author
			->setNom($nom)
			->setPrenom($prenom)
			->setNationalite($nationalite)
			->setVivant($vivant);
		$em->flush();

		return new Response('updated');
       
	}

}
