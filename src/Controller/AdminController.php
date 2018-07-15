<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FDUser;
use App\Form\LogType;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
	/**
     * @Route("/logs", name="logs")
     */
    public function logsAction(Request $request)
    {
        //patata =sv0h0sr
    	$category = "null";
        $categoryData = null;
        $em = $this->getDoctrine()->getManager();
    	$form = $this->createForm(LogType::class);
    	$form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $category = $data['category'];
            switch($category) 
            {
                case "description": $categoryData = $em->getRepository("App:DescriptionLog")->findAll();break;
                case "nickname": $categoryData = $em->getRepository("App:NicknameLog")->findAll();break;
                case "propic": $categoryData = $em->getRepository("App:PropicLog")->findAll();break;
                case "ban": $categoryData = $em->getRepository("App:BanLog")->findAll();break; 
            }
    	}
        return $this->render("logs.html.twig", array(
        	"form" => $form->createView(),
            "data" => $categoryData,
            "logtype" => $category
        ));
    }
}