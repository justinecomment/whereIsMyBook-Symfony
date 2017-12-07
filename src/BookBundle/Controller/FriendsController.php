<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\CorsBundle\NelmioCorsBundle;
use BookBundle\Entity\Friends;

class FriendsController extends Controller
{

	/**
	* @Route("/listFriends", name="friends_list")
	*/
	public function getAllAction()
	{
		$friends = $this->getDoctrine()->getRepository('BookBundle:Friends')->findAll();
		$data = $this->get('jms_serializer')->serialize($friends, 'json');

		return new Response($data);
	}

	/**
	* @Route("/friend/{id}", name="get_friend")
	*/
	public function getAction(Friends $friend)
	{
		$friend = $this->get('jms_serializer')->serialize($friend, 'json');
		$response = new Response($friend);

		return $response;
	}


	/**
	* @Route("/addFriend", name="add_friend")
    * @Method({"POST"})
	*/
	public function createAction(Request $request)
	{	
		$data = $request->getContent();
		$friend = $this->get('jms_serializer')->deserialize($data, 'BookBundle\Entity\Friends' ,'json');

		$em = $this->getDoctrine()->getManager();
		$em->persist($friend);
		$em->flush();

		return new Response('added', Response::HTTP_CREATED);
	}

	/**
	* @Route("/deleteFriend/{id}", name="delete_friend")
    * @Method({"DELETE"})
	*/
	public function deleteAction(Friends $friend)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($friend);
		$em->flush();

		return new Response('deleted');
	}


	/**
	* @Route("/updateFriend/{id}", name="update_friend")
    * @Method({"PUT"})
	*/
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$friend = $em->getRepository('BookBundle:Friends')->find($id);

		$content = $request->getContent();
		$data = json_decode($content, true);
		
		$nom = $data['nom'];
		$prenom = $data['prenom'];

		$friend
			->setNom($nom)
			->setPrenom($prenom);
		$em->flush();

		return new Response('updated');
       
	}



}
