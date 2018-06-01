<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
	/**
	 * @Route("/")
	 */
	public function mainAction(Request $request)
	{
		return $this->render("map.html.twig");
	}
}