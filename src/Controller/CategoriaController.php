<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\CategoriaRepository;
use App\Repository\UserRepository;
use App\Repository\EventoRepository;
Use App\Entity\Categoria;
Use App\Entity\User;
use App\Form\Type\CategoriaTipoType;
use App\Form\Type\CategoriaType;
use App\Form\Type\CategoriaCreateType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CategoriaController extends AbstractController {

    /**
     * @Route("/indexCategoria", name="indexCategoria")
     */
    public function indexCategoria(CategoriaRepository $catRepo, Request $request):Response{
        $form=$this->createForm(CategoriaType::class);
        $form->handleRequest($request);
        $formVista=$form->createView();
        $categorias=$catRepo->findAll();
            if($form->isSubmitted()&&$form->isValid()){

                //$cat = $catRepo->findOneBy(array('nombre' => 'categoria'));

                $cat = $form->get("categoria")->getData();

                $id = $cat->getId();
                //$id = 2;

                //$id = $form->getData('categoria');
                return $this->redirectToRoute("categoria", ["id" => $id]);
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
        $eventos=$eventoRepo->findBy(["idCategoria"=>$id]);
        if(empty($eventos)){
            $this->addFlash("danger", "No se han encontrado eventos");
        }else{
            return $this->render("categoria/vistaEventos.html.twig", [
                'lstEventos'=>$eventos
            ]);
        }
    }

    /**
     * @Route("/admin/categoria", name="adminCategoria")
    */
    public function adminCategoria(CategoriaRepository $catRepo, UserRepository $userRepo){
        $user=$userRepo->findAll();
        $categorias=$catRepo->findAll();
        return $this->render('categoria/admin.html.twig', [
            'lstCat'=>$categorias,
            'lstUsr'=>$user
        ]);
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
        $form=$this->createForm(CategoriaCreateType::class, $categoria);
        $form->handleRequest($request);
        $formVista=$form->createView();
        $imagen=$form->get('imagen')->getData();
        if($form->isSubmitted()&&$form->isValid()){
            //$categoria=$form->getData();
            if($imagen){
                $nuevoNombre="cat";
                $newFileName=$nuevoNombre."-".uniqid().".".$imagen->guessExtension();
                $path="imgs/imgCat";
                $pathImagen=$path."/".$newFileName;
                try{
                    $imagen->move($path,$newFileName);
                }catch(FileException $e){}
                if($pathImagen!=null&&$pathImagen!=""){
                    if($categoria->getImagen()!=""){
                        \unlink($categoria->getImagen());
                    }
                    $categoria->setImagen($pathImagen);
                }
            }
            $categoria->setNombre($form["categoria"]->getData());
            $categoria->setComentario($form["text"]->getData());

            $this->getDoctrine()->getManager()->persist($categoria);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Categoría editada correctamente");
            return $this->redirectToRoute("adminCategoria");
        }
        return $this->render('categoria/edit.html.twig', [
            "form"=>$formVista
        ]);
    }

    /**
     * @Route("/admin/addCategoria", name="addCategoria")
     */
    public function addCategoria(Request $request):Response{
        $categoria=new Categoria();
        $form=$this->createForm(CategoriaCreateType::class, $categoria);
        $form->handleRequest($request);
        $formVista=$form->createView();

        if($form->isSubmitted()&&$form->isValid()){
            $imagen=$form->get('imagen')->getData();
            $categoria=$form->getData();
            if($imagen){
                $nuevoNombre="cat";
                $newFileName=$nuevoNombre."-".uniqid().".".$imagen->guessExtension();
                $path="imgs/imgCat";
                $pathImagen=$path."/".$newFileName;
                try{
                    $imagen->move($path,$newFileName);
                }catch(FileException $e){}
                if($pathImagen!=null&&$pathImagen!=""){
                    if($categoria->getImagen()!=""){
                        \unlink($categoria->getImagen());
                    }
                    $categoria->setImagen($pathImagen);
                }
            }
            $categoria->setNombre($form["categoria"]->getData());
            $categoria->setComentario($form["text"]->getData());
            $this->getDoctrine()->getManager()->persist($categoria);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("succes", "Categoría creada correctamente");

            return $this->redirectToRoute("adminCategoria");
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
        return $this->redirectToRoute("adminCategoria");
    }

}

?>
