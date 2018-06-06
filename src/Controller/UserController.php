<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Propic;
use App\Entity\User;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

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
		$path = "/images/propics/" . (($user->hasPropic())?$user->getPropic():"default.png");
		return $this->render("profile/profile.html.twig", array(
			"user" => $user,
            "propic" => $path
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
		return $this->render("profile/editprofile.html.twig", array(
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
    		->add('nickname', Type\HiddenType::class, array(
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
                'label' => "Cambia"
            ))
    		->getForm();

    	$form->handleRequest($request);
        if($form->isSubmitted())
        {
            if($form->isValid()) 
            {
                $data = $form->getData();
                $user->setPassword($encoder->encodePassword($user, $data['password']));
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

    	return $this->render('profile/editpwd.html.twig', array(
    		'form' => $form->createView()
    	));
    }

    /**
     * @Route("/profile/upload-profile-image", name="upload-profile-image")
     */
    public function uploadPropicAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $encoder = $this->container->get('security.password_encoder');
        $propic = new Propic();

        $user = $this->getUser();       
        $form = $this->createFormBuilder($propic)
            ->add('propic', Type\FileType::class, array(
                'data_class' => Propic::class,
            ))
            ->add('submit', Type\SubmitType::class, array(
                'label' => "Cambia"
            ))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            if($form->isValid()) 
            {
                $file = $propic->getPropic();
                $fileSystem = new Filesystem();
                $dirPath = $this->getParameter('propic_directory');
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $dirPath,
                    $fileName
                );

                if($user->hasPropic()) {
                    $fileSystem->remove($dirPath . $user->getPropic());
                }
                

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $user->setPropic($fileName);

                // ... persist the $product variable or any other work
                $em->flush();

                return $this->redirect($this->generateUrl('profile'));
            } else {
                $errors = $form->getErrors(true);

                foreach($errors as $error) 
                {
                    dump($error);
                    $this->addFlash('notice' , $error->getMessage());
                }
            }
        }

        return $this->render('profile/editpropic.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
