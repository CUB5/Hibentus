<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ComentarioRepository;
use App\Repository\EventoRepository;
use App\Repository\UserRepository;
Use App\Entity\Comentario;
use App\Form\Type\ComentarioType;

/**
 * @Route("/profile", name="profile")
 */
class ComentarioController extends AbstractController {

    /**
     * @Route("/comentario/{idUser}", name="comentario")
     */
    public function indexComentario(ComentarioRepository $comRepo,$idUser):Response{
        $listaComentarios=$comRepo->findBy(["id_user_id"=>$idUser]);
        return $this->render("comentario/index.html.twig", [
            'listaComentarios'=>$listaComentarios
        ]);
    }

    /**
     * @Route("/admin/editComentario/{id}", name="editComentario")
     */
    public function editComentario($id, ComentarioRepository $comRepo, Request $request): Response{
        $comentario=new Comentario();
        $comentario=$comRepo->find($id);
        if($comentario==null){
            $this->addFlash("danger", "Comentario no encontrado");
            return $this->redirectToRoute("comentario");
        }
        $form=$this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $comentario=$form->getData();
            $this->getDoctrine()->getManager()->persist($comentario);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Comentario editado correctamente");
            return $this->redirectToRoute("comentario");
        }
        return $this->render('comentario/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/admin/addComentario/{idEvento}/{idUsu}", name="addComentario")
     */
    public function addComentario($idEvento, $idUsu, EventoRepository $eventoRepo, UserRepository $userRepo ,Request $request):Response{
        $comentario=new Comentario();
        $form=$this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $comentario=$form->getData();
            $evento=$eventoRepo->find($idEvento);
            $user=$userRepo->find($idUsu);
            $comentario->setIdEvento($evento);
            $comentario->setIdUser($user);
            $this->getDoctrine()->getManager()->persist($comentario);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Comentario creado correctamente");
            return $this->redirectToRoute("index");
        }
        return $this->render("comentario/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/deleteComentario/{id}", name="deleteComentario")
     */
    public function deleteComentario($id, ComentarioRepository $comRepo):Response{
        $comentario=$comRepo->find($id);
        if($comentario==null){
            $this->addFlash("danger", "El comentario no existe");
        }else{
            $this->getDoctrine()->getManager()->remove($comentario);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Se ha eliminado el comentario");
        }
        return $this->redirectToRoute("comentario");
    }

}

?>