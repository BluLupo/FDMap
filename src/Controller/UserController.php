<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
	/**
	 * @Route("/profile", name="profile")
	 */
	public function userAction(Request $request)
	{
		$user = $this->getUser();
		
		return $this->render("profile.html.twig", array(
			"form" => $form->createView()
		));		
	}

	public function editAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$form = $this->createFormBuilder()
			->add('nickname', Type\TextType::class, array(
				'required' => true, 
				'attr' => array(
                    'placeholder' => "Nickname"                
                )
			))
			->add('description', Type\TextType::class, array(
				'attr' => array(
					'placeholder' => "Descrizione (max. 255 caratteri)"
				)
			))
			->add('submit', Type\SubmitType::class)
			->getForm();

		$form->handleRequest($request);
		if($form->isSubmitted())
		{
			if($form->isValid()) 
            {
            	$data = $form->getData();
            	$user->setNickname($data['nickname']);
            	$user->setDescription($data['description']);
                $em->flush();
    		    return $this->redirectToRoute("map");
            } else {
                $errors = $form->getErrors(true);

                foreach($errors as $error) 
                {
                    $this->addFlash('notice' , $error->getMessage());
                }
            }
		}
		return $this->render("editprofile.html.twig", array(
			"form" => $form->createView()
		));
	}
}