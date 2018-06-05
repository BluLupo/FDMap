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
			"user" => $user
		));		
	}

	/**
	 * @Route("/profile/edit", name="profile_edit")
	 */
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
				$user = $this->getUser();
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

	/**
	 * @Route("/password/new", name="password_reset")
	 */
	public function newPasswordAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
    	$encoder = $this->container->get('security.password_encoder');

    	$user = $this->getUser();		
    	$form = $this->createFormBuilder()
    		->add('nickname', Type\HidentType::class, array(
    			'data' => $user->getNickname()
    		))
    		->add('password', Type\PasswordType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => "Password"
                )
            ))
            ->add('password2', Type\PasswordType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => "Ripeti password"
                )
            ))
    		->add('submit', Type\SubmitType::class, array(
                'label' => "Registra"
            ))
    		->getForm();

    	$form->handleRequest($request);
        if($form->isSubmitted())
        {
            if($form->isValid()) 
            {
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                $em->flush();
    		    return $this->redirectToRoute("profile");
            } else {
                $errors = $form->getErrors(true);

                foreach($errors as $error) 
                {
                    dump($error);
                    $this->addFlash('notice' , $error->getMessage());
                }
            }
    	}

    	return $this->render('editprofile.html.twig', array(
    		'form' => $form->createView()
    	));
    }
}
