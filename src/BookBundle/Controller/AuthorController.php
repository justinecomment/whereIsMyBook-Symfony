<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
}
