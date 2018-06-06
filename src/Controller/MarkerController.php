<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use App\Form\MarkerType;
use App\Entity\Marker;

/**
 - @Route("/marker")
 */
class MarkerController extends Controller
{
	/**
	 * @Route("/all", name="get_all_markers")
	 * @Method("GET")
	 */
	public function getMarkersAction(Request $request)
	{
		$markers = $this->getDoctrine()->getManager()->getRepository('App:Marker')->findAll();
		$result = array();
		foreach($markers as $marker) {
			$user = $marker->getUser();
			array_push($result, array(
				'latitude' => $marker->getLatitude(),
				'longitude' => $marker->getLongitude(),
				'nickname' => $user->getNickname(),
				'propic' => "images/propics/".($user->hasPropic()?$user->getPropic():"default.png"),
				'description' => $user->getDescription()
			));
		}

		return new JsonResponse($result);
	}

	/**
	 * @Route("/add", name="add_marker")
	 */
	public function addMarkerAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$postData = $request->request->all();
		$user = $this->getUser();
		$marker = (new Marker())
			->setLatitude($postData['latitude'])
			->setLongitude($postData['longitude'])
			->setUser($user);

		$em->persist($marker);
		$em->flush();

		return new JsonResponse(array("success" => true));
	}

	/**
	 * @Route("/move", name="edit_marker")
	 */
	public function moveMarkerAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$postData = $request->request->all();
		$user = $this->getUser();
		$marker = $user->getMarker();

		$marker
			->setLatitude($postData['latitude'])
			->setLongitude($postData['longitude']);

		$em->persist($marker);
		$em->flush();

		return new JsonResponse(array("success" => true));
	}

	/**
	 * @Route("/delete", name="delete_marker")
	 */
	public function deleteMarkerAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$postData = $request->request->all();
		$user = $this->getUser();
		$marker = $user->getMarker();

		$user->setMarker(null);
		$em->remove($marker);
		$em->flush();

		return new JsonResponse(array("success" => true));
	}
}