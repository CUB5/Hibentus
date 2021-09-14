<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\CategoriaRepository;
use App\Repository\EventoRepository;
Use App\Entity\Categoria;
use App\Form\Type\CategoriaTipoType;
use App\Form\Type\CategoriaType;

class CategoriaController extends AbstractController {

    /**
     * @Route("/indexCategoria", name="indexCategoria")
     */
    public function indexCategoria(CategoriaRepository $catRepo, Request $request):Response{
        $form=$this->createForm(CategoriaTipoType::class);
        $form->handleRequest($request);
        $formVista=$form->createView();
        $categorias=$catRepo->findAll();
        if($form->isSubmitted()&&$form->isValid()){
            $id=$form->getData('id_categoria_id');
            return $this->redirectToRoute("/categoria/$id");
        }
        return $this->render('categoria/index.html.twig', [
            'lstCat'=>$categorias,
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/categoria/{id}", name="categoria")
     */
    public function eventosCategoria($id, EventoRepository $eventoRepo){
        $eventos=$eventoRepo->findBy(["id_categoria_id"=>$id]);
        if(empty($eventos)){
            $this->addFlash("danger", "No se han encontrado eventos");
        }else{
            return $this->render("categoria/vistaEventos.html.twig", [
                'lstEventos'=>$eventos
            ]);
        }
    }

     /**
     * @Route("/admin/editCategoria/{id}", name="editCategoria")
     */
    public function editCategoria($id, CategoriaRepository $catRepo, Request $request): Response{
        $categoria=new Categoria();
        $categoria=$catRepo->find($id);
        if($categoria==null){
            $this->addFlash("danger", "Categoría no encontrada");
            return $this->redirectToRoute("indexCategoria");
        }
        $form=$this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $categoria=$form->getData();
            $this->getDoctrine()->getManager()->persist($categoria);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Categoría editada correctamente");
            return $this->redirectToRoute("indexCategoria");
        }
        return $this->render('categoria/edit.html.twig', ["form"=>$formVista]);
    }

    /**
     * @Route("/admin/addCategoria", name="addCategoria")
     */
    public function addCategoria(Request $request):Response{
        $categoria=new Categoria();
        $form=$this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);
        $formVista=$form->createView();
        if($form->isSubmitted()&&$form->isValid()){
            $categoria=$form->getData();
            $this->getDoctrine()->getManager()->persist($categoria);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Categoría creada correctamente");
            return $this->redirectToRoute("indexCategoria");
        }
        return $this->render("categoria/edit.html.twig", [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/deleteCategoria/{id}", name="deleteCategoria")
     */
    public function deleteCategoria($id, CategoriaRepository $catRepo):Response{
        $categoria=$catRepo->find($id);
        if($categoria==null){
            $this->addFlash("danger", "La categoría no existe");
        }else{
            $this->getDoctrine()->getManager()->remove($categoria);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Se ha eliminado la categoría");
        }
        return $this->redirectToRoute("indexCategoria");
    }

}

?>