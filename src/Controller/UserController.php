<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


use App\Repository\UserRepository;
Use App\Entity\User;
use App\Form\Type\UserType;
use App\Form\Type\EditFieldType;
use App\Form\Type\RoleChooseType;
use App\Form\Type\ChangePasswordType;


/**
 * @Route("/profile", name="profile")
 */
class UserController extends AbstractController {

    /**
     * @Route("/user", name="_user")
     */
    public function indexUser():Response{
        return $this->render("user/index.html.twig");
    }

    /**
     * @Route("/admin/editUser/{param}/{id<\d+>}", name="_editUser")
     */
    public function editUser($id, $param, UserRepository $userRepo, Request $request): Response{
        $user=new User();
        $user=$userRepo->find($id);
        if($user==null){
            $this->addFlash("danger", "Usuario no encontrado");
            return $this->redirectToRoute("user");
        }
        $form=$this->createForm(EditFieldType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            if($param == 1){
                $data = $form['input']->getData();

                $user->setUsername($data);

            }
            if($param == 2){
                $data = $form['input']->getData();

                $user->setNombre($data);

            }
            if($param == 3){
                $data = $form['input']->getData();

                $user->setEmail($data);

            }

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Usuario editado correctamente");

            return $this->redirectToRoute("profile_user");
        }
        return $this->render('user/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/admin/addUser", name="_addUser")
     */
    public function addUser(Request $request, UserPasswordHasherInterface $hasher):Response{
        $user=new User();
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $user=$form->getData();
            $pass = $form->get('password')->getData();
            $hashedPass = $hasher->hashPassword($user, $pass);
            $user->setPassword($hashedPass);
            $rol=$form->get('roles')->getData();
            $roles=explode(",", $rol);
            $user->setRoles($roles);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Usuario creado correctamente");
            return $this->redirectToRoute("profile_user");
        }
        return $this->render("user/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/editPassword", name="_editPassword")
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $hasher){

        $user = $this->getUser();

        if ($user == null) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form=$this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        
        if ($form->isSubmitted() && $form->isValid()) {

            $pass = $form->get('password')->getData();

            $hashedPass = $hasher->hashPassword($user, $pass);

            $user->setPassword($hashedPass);
            
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Contraseña cambiada correctamente");
            
            return $this->redirectToRoute("profile_user");

        }

        return $this->render("user/edit.html.twig", [
            "form"=>$formVista
        ]);

    }

    /**
     * @Route("/admin/editUserRole/{id}", name="_editUserRole")
     */
    public function editUserRole($id, UserRepository $userRepo, Request $request){
        $user = new User();
        $user = $userRepo->find($id);

        if($user == null){
            $this->addFlash("danger", "Categoría no encontrada");
            return $this->redirectToRoute("indexCategoria");
        }

        $form=$this->createForm(RoleChooseType::class, $user);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            //$categoria=$form->getData();

            $user->setRoles([$form["roles"]->getData()]);

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Categoría editada correctamente");

            return $this->redirectToRoute("adminCategoria");
        }
        return $this->render('categoria/edit.html.twig', [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/deleteUser/{id}", name="_deleteUser")
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
        return $this->redirectToRoute("adminCategoria");
    }

    /**
     * @Route("/admin/listaUsuarios/{page<\d+>}", name="listaUsuarios")
     */
    public function listaUsuarios($page=1, UserRepository $userRepo):Response{
        $usuarios=$userRepo->findAllPaginado($page);
        return $this->render('user/listaUser.html.twig', [
            "listaUsu"=>$usuarios["res"],
            "page"=>$page,
            "nMaxPages"=>$usuarios["nMaxPages"]
        ]);
    }

}

?>