<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EventoRepository;
use App\Repository\CategoriaRepository;
use App\Repository\ParticipanteRepository;
Use App\Entity\Evento;
use App\Form\Type\EventoType;
use App\Repository\ComentarioRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class EventosController extends AbstractController {

    /**
     * @Route("/admin/evento/{page<\d+>}", name="evento")
     */
    public function indexEvento($page=1,EventoRepository $eventoRepo):Response{
        $listaEvento=$eventoRepo->findAllPaginado($page);
        return $this->render("evento/index.html.twig", [
            'listaEventos'=>$listaEvento['res'],
            'page'=>$page,
            'nMaxPages'=>$listaEvento["nMaxPages"]
        ]);
    }

    /**
     * @Route("/vistaEvento/{id}", name="vistaEvento")
     */
    public function vistaEvento(EventoRepository $eventoRepo, ComentarioRepository $comRepo, ParticipanteRepository $partRepo ,$id):Response{
        $evento=new Evento();
        $evento=$eventoRepo->find($id);
        if($evento==null){
            $this->addFlash("danger", "Evento no encontrada");
            return $this->redirectToRoute("evento");
        }
        $comentarios=$comRepo->findByIdEvento(["id_evento_id"=>$id]);
        $participantes=$partRepo->findByIdEvento(["id_evento_id"=>$id]);
        return $this->render("evento/vista.html.twig", [
            "evento"=>$evento,
            "lstComentarios"=>$comentarios,
            "lstParticipantes"=>$participantes
        ]);
    }

    /**
     * @Route("/admin/editEvento/{id}", name="editEvento")
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
            $imagen=$form->get('imagen')->getData();
            $evento=$form->getData();
            if($imagen){
                $nuevoNombre="evento";
                $newFileName=$nuevoNombre.'-'.uniqid().'.'.$imagen->guessExtension();
                $path="imgs/imgEvento";
                $pathImagen=$path."/".$newFileName;
                try{
                    $imagen->move($path, $newFileName);
                }catch(FileException $e){}
                if($pathImagen!=null&&$pathImagen!=""){
                    if($evento->getImagen()!=""){
                        \unlink($evento->getImagen());
                    }
                    $evento->setImagen($pathImagen);
                }
            }
            $this->getDoctrine()->getManager()->persist($evento);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Evento editado correctamente");
            return $this->redirectToRoute("evento");
        }
        return $this->render('evento/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/admin/addEvento", name="addEvento")
     */
    public function addEvento(Request $request):Response{
        $evento=new Evento();
        $form=$this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $imagen=$form->get('imagen')->getData();
            $evento=$form->getData();
            if($imagen){
                $nuevoNombre="evento";
                $newFileName=$nuevoNombre.'-'.uniqid().'.'.$imagen->guessExtension();
                $path="imgs/imgEvento";
                $pathImagen=$path."/".$newFileName;
                try{
                    $imagen->move($path, $newFileName);
                }catch(FileException $e){}
                if($pathImagen!=null&&$pathImagen!=""){
                    if($evento->getImagen()!=""){
                        \unlink($evento->getImagen());
                    }
                    $evento->setImagen($pathImagen);
                }
            }
            $fechaCreacion=new \DateTime();
            $evento->setFechaCreacion($fechaCreacion);
            $this->getDoctrine()->getManager()->persist($evento);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Evento editado correctamente");
            return $this->redirectToRoute("evento");
        }
        return $this->render("evento/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/deleteEvento/{id}", name="deleteEvento")
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

    /**
     * @Route("/eventosActivos/{page<\d+>}", name="eventosActivos")
     */
    public function eventosActivos($page=1, EventoRepository $eventoRepo):Response{
        $limit=10;
        $fechaActual=new \DateTime();
        $consultaActivos=$eventoRepo->createQueryBuilder('e')
            ->where(":fechaActual BETWEEN e.fechaInicio AND  e.fechaFin")
            ->setParameter('fechaActual', $fechaActual)
            ->setFirstResult($limit*($page-1))
            ->setMaxResults($limit)
            ->getQuery();
        $consultaEventosActivos=$eventoRepo->createQueryBuilder('e')
            ->where(":fechaActual BETWEEN e.fechaInicio AND  e.fechaFin")
            ->setParameter('fechaActual', $fechaActual)
            ->getQuery();  
        $eventosActivos=$consultaActivos->getResult();
        $todosEventosActivos=$consultaEventosActivos->getResult();
        $numEventos=count($todosEventosActivos);
        $maxPags=ceil($numEventos/$limit);
        return $this->render("evento/activos.html.twig", [
            "eventosActivos"=>$eventosActivos,
            "nMaxPages"=>$maxPags,
            'page' => $page
        ]);
    }

}

?>