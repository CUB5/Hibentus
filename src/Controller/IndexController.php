<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventoRepository;
use App\Repository\CategoriaRepository;

class IndexController extends AbstractController {

    /**
     * @Route("/{page<\d+>}", name="index")
     */
    public function index($page=1, EventoRepository $eventoRepo, CategoriaRepository $catRepo):Response{
        $eventos=$eventoRepo->findAllPaginado($page);
        $categorias=$catRepo->findAll();
        return $this->render('index/index.html.twig', [
            'lstEventos'=>$eventos["res"],
            'lstCat'=>$categorias,
            'page' => $page,
            'nMaxPages' => $eventos["nMaxPages"]
        ]);
    }

}

?>