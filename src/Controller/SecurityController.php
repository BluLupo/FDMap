<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\FDUser;


class SecurityController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return $this->render('base.html.twig');
    }

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
    	$encoder = $this->container->get('security.password_encoder');

    	$form = $this->createFormBuilder($user)
    		->add('nickname', Type\TextType::class)
    		->add('password', Type\PasswordType::class)
            ->add('password2', Type\PasswordType::class, array(
                'label' => "Ripeti password"
            ))
    		->add('submit', Type\SubmitType::class, array(
                'label' => "Registra"
            ))
    		->getForm();

    	$form->handleRequest($request);
    	if($form->isSubmitted() && $form->isValid()) 
    	{
    		$user->setPassword($encoder->encodePassword($user, $user->getPassword()));
    		$em->persist($user);
    		$em->flush();
    		return $this->redirectToRoute("login");
    	}

    	return $this->render('security/register.html.twig', array(
    		'form' => $form->createView()
    	));
    } 
}