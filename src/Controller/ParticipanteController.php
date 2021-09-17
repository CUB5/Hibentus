<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Use App\Entity\Participante;
use App\Repository\UserRepository;
use App\Repository\EventoRepository;
use App\Repository\ParticipanteRepository;


class ParticipanteController extends AbstractController
{
    /**
     * @Route("/participante", name="participante")
     */
    public function index(): Response
    {
        return $this->render('participante/index.html.twig', [
            'controller_name' => 'ParticipanteController',
        ]);
    }

    /**
     * @Route("/participante/apuntarse/{evento}/{id}", name="participa")
     */
    public function participa($evento, $id, EventoRepository $eventoRepo,  UserRepository $userRepo): Response{
        
        $repository = $this->getDoctrine()->getRepository(Participante::class);

        $element = $repository->findOneBy(
                    ['idEvento'=>$evento, 
                    'id_usuario'=>$id]
                );

        if (!$element) {
            
            $part = new Participante();

            $part->setIdEvento($eventoRepo->find($evento));
            $part->setIdUsuario($userRepo->find($id));

            $this->getDoctrine()->getManager()->persist($part);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("vistaEvento", ["id"=>$evento]);
        }

        $this->addFlash("danger", "¡Ya estas participando!");
        return $this->redirectToRoute("vistaEvento", ["id"=>$evento]);
       


    }

    /**
     * @Route("participante/borrarse/{id}", name="borrarse")
     */
    public function borrarse($id, ParticipanteRepository $partRepo):Response{
        $participante=$partRepo->find($id);
        if($participante==null){
            $this->addFlash("danger", "El evento no existe");
        }else{
            $this->getDoctrine()->getManager()->remove($participante);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Te has borrado del evento");
        }
        return $this->redirectToRoute("profileuser");
    }
}
