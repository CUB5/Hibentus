<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventoRepository;
use App\Repository\CategoriaRepository;

class IndexController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index(EventoRepository $eventoRepo, CategoriaRepository $catRepo):Response{
        $eventos=$eventoRepo->findAll();
        $categorias=$catRepo->findAll();
        return $this->render('index/index.html.twig', [
            'lstEventos'=>$eventos,
            'lstCat'=>$categorias
        ]);
    }

}

?>