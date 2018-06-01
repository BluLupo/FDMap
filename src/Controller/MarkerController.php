<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

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
		$users = $this->getDoctrine()->getManager()->getRepository('App:FDUser')->findAll();
		$serializer = $this->container->get('jms_serializer');

		return new JsonResponse(json_decode(
				$serializer->serialize(
					$users, 
					'json',
					SerializationContext::create()
						->setGroups('markers')
						->setSerializeNull(true)
				)
			)
		);
	}
}