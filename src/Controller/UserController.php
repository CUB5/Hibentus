<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
Use App\Entity\User;
use App\Form\Type\UserType;

class UserController extends AbstractController {

    /**
     * @Route("/user", name="user")
     */
    public function indexUser():Response{
        return $this->render("user/index.html.twig");
    }

    /**
     * @Route("/editUser/{id}", name="editUser")
     */
    public function editUser($id, UserRepository $userRepo, Request $request): Response{
        $user=new User();
        $user=$userRepo->find($id);
        if($user==null){
            $this->addFlash("danger", "Usuario no encontrado");
            return $this->redirectToRoute("user");
        }
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $user=$form->getData();
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Usuario editado correctamente");
            return $this->redirectToRoute("user");
        }
        return $this->render('user/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/addUser", name="addUser")
     */
    public function addUser(Request $request):Response{
        $user=new User();
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $user=$form->getData();
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Usuario creado correctamente");
            return $this->redirectToRoute("user");
        }
        return $this->render("user/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function deleteUser($id, UserRepository $userRepo):Response{
        $user=$userRepo->find($id);
        if($user==null){
            $this->addFlash("danger", "El usuario no existe");
        }else{
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Se ha eliminado el usuario");
        }
        return $this->redirectToRoute("user");
    }

}

?>