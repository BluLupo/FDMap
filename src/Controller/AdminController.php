<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PunishType;
use App\Entity\FDUser;

/**
 * @Route("/admin/user")
 */
class AdminController extends Controller
{
    /**
     * @Route("/list", name="users_list")
     */
    public function usersListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("App:FDUser")->findAll();

        return $this->render("userlist.html.twig", array(
            "users" => $users
        ));
    }

    /**
     * @Route("/{user}/removeDescription")
     */
    public function deleteDescriptionAction(Request $request, FDUser $user)
    {
        $em = $this->getDoctrine()->getManager();

        $user->setDescription(null);
        $em->flush();
        return $this->redirectToRoute("users_list"); 
    }

    /**
     * @Route("/{user}/removeNickname")
     */
    public function deleteNicknameAction(Request $request, FDUser $user)
    {
        $em = $this->getDoctrine()->getManager();

        $user->setNickname($user->getLogin());
        $em->flush();
        return $this->redirectToRoute("users_list"); 
    }

    /**
     * @Route("/{user}/removeProfilePicture")
     */
    public function deletePropicAction(Request $request, FDUser $user)
    {
        $em = $this->getDoctrine()->getManager();

        $user->setPropic(null);
        $em->flush();
        return $this->redirectToRoute("users_list"); 
    }

    /**
     * @Route("/{user}/punish")
     */
    public function punishAction(Request $request, FDUser $user)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PunishType::class, $user, array(
            "validation_groups" => array("ban")
        ));
        $form->handleRequest($request);
        $err = null;
        if($form->isSubmitted()) {
            if ($form->isValid()) {
                $user->setBanned(true);
                $em->flush();
                return $this->redirectToRoute("users_list"); 
            } else {
                $errors = $form->getErrors(true);

                foreach($errors as $error) 
                {
                    $err = $error;
                }
            }
        }

        return $this->render("punish.html.twig", array(
            "form" => $form->createView(),
            "error" => $err
        ));
    }

    /**
     * @Route("/{user}/pardon")
     */
    public function pardonAction(Request $request, FDUser $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user
            ->setBanned(false)
            ->setPermanentBan(false)
            ->setEndDate(null)
        ;
        $em->flush();
        return $this->redirectToRoute("users_list"); 
    }

    /**
     * @Route("/{user}/promote/{role}")
     */
    public function promoteAction(Request $request, FDUser $user, $role)
    {
        $em = $this->getDoctrine()->getManager();
        $user
            ->setRole($role)
        ;
        $em->flush();
        return $this->redirectToRoute("users_list"); 
    }
}
