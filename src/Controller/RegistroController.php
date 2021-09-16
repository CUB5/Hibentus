<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\Type\UsuarioRegistroType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $req, UserPasswordHasherInterface $hasher, UserRepository $repo): Response {
        $usuario = new User();
        $form = $this->createForm(UsuarioRegistroType::class, $usuario, ['csrf_protection'=>true]);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()) {
            //$usuario = $form->getData();
            
            $plainPass = $form->get('password')->getData();
            $hashedPass = $hasher->hashPassword($usuario, $plainPass);
            
            $usuario->setPassword($hashedPass);
            
            $userBuscado = $repo->findOneBy(["username"=> $usuario->getUserIdentifier()]);
            if($userBuscado==null) {
                $this->getDoctrine()->getManager()->persist($usuario);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash("success", "Usuario registrado correctamente!!!");

                return $this->redirectToRoute("index");
            } else {
                $this->addFlash("danger", "Ya existe un usuario con ese username!!!");
            }
        }

        return $this->render('registro/index.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
