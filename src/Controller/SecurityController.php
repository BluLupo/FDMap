<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\FDUser;
use Symfony\Component\Form\Extension\Core\Type;

class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
    public function login(Request $request,  AuthenticationUtils $authenticationUtils)
    {
    	// get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render('security/login.html.twig', array(
	        'last_username' => $lastUsername,
	        'error'         => $error,
	    ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = new FDUser();
    	$form = $this->createFormBuilder($user)
    		->add('nickname', Type\TextType::class)
    		->add('password', Type\PasswordType::class)
    		->add('submit', Type\SubmitType::class)
    		->getForm();

    	$form->handleRequest($request);
    	if($form->isSubmitted() && $form->isValid()) 
    	{
    		$em->persist($user);
    		$em->flush();
    		return $this->redirectToRoute("login");
    	}

    	return $this->render('security/register.html.twig', array(
    		'form' => $form->createView()
    	));
    } 
}