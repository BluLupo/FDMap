<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MarkerType;
use App\Entity\Marker;

class MainController extends Controller
{
	/**
	 * @Route("/", name="map")
	 */
	public function mainAction(Request $request)
	{
		$marker = new Marker;
		$form = $this->createForm(MarkerType::class, $marker);
		$marker = $this->getUser()->getMarker();
		$marked = isset($marker);
		$user = $this->getUser();
		return $this->render("map.html.twig", array(
			"form" => $form->createView(),
			"marked" => $marked,
			"nickname" => $user->getNickname(),
			"propic" => "/images/propics/" . (($user->hasPropic())?$user->getPropic():"default.png"),
		));
	}

	/**
	 * @Route("/banned", name="banned")
	 */
	public function bannedAction(Request $request)
	{
		return $this->render("security/banned.html.twig", array(
			"user" => $this->getUser()
		));
	}
}