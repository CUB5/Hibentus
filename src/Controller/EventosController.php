<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EventoRepository;
use App\Repository\CategoriaRepository;
Use App\Entity\Evento;
use App\Form\Type\EventoType;
use App\Repository\ComentarioRepository;

class EventosController extends AbstractController {

    /**
     * @Route("/evento", name="evento")
     */
    public function indexEvento(EventoRepository $eventoRepo, ComentarioRepository $comRepo):Response{
        $listaEvento=$eventoRepo->findAll();
        return $this->render("eventos/index.html.twig", [
            'listaEventos'=>$listaEvento
        ]);
    }

    /**
     * @Route("/vistaEvento/{id}", name="vistaEvento")
     */
    public function vistaEvento(EventoRepository $eventoRepo, ComentarioRepository $comRepo, $id):Response{
        $evento=new Evento();
        $evento=$eventoRepo->find($id);
        if($evento==null){
            $this->addFlash("danger", "Evento no encontrada");
            return $this->redirectToRoute("evento");
        }
        $comentarios=$comRepo->findBy(["id_evento_id"=>$id]);
        return $this->render("eventos/vista.html.twig", [
            "evento"=>$evento,
            "lstComentarios"=>$comentarios
        ]);
    }

    /**
     * @Route("/editEvento/{id}", name="editEvento")
     */
    public function editEvento($id, EventoRepository $eventoRepo, Request $request): Response{
        $evento=new Evento();
        $evento=$eventoRepo->find($id);
        if($evento==null){
            $this->addFlash("danger", "Evento no encontrada");
            return $this->redirectToRoute("evento");
        }
        $form=$this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $evento=$form->getData();
            $this->getDoctrine()->getManager()->persist($evento);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Evento editado correctamente");
            return $this->redirectToRoute("evento");
        }
        return $this->render('eventos/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/addEvento", name="addEvento")
     */
    public function addEvento(Request $request):Response{
        $evento=new Evento();
        $form=$this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $evento=$form->getData();
            $this->getDoctrine()->getManager()->persist($evento);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Evento creado correctamente");
            return $this->redirectToRoute("evento");
        }
        return $this->render("eventos/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/deleteEvento/{id}", name="deleteEvento")
     */
    public function deleteEvento($id, EventoRepository $eventoRepo):Response{
        $evento=$eventoRepo->find($id);
        if($evento==null){
            $this->addFlash("danger", "El evento no existe");
        }else{
            $this->getDoctrine()->getManager()->remove($evento);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Se ha eliminado el evento");
        }
        return $this->redirectToRoute("evento");
    }

}

?>