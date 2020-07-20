<?php
/**
 * Created by PhpStorm.
 * User: MPHASIS
 * Date: 05/07/2020
 * Time: 21:08
 */

namespace IS\MainBundle\Controller;


use IS\MainBundle\Entity\Category;
use IS\MainBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ISMainBundle:Category')->findAll();


        return $this->render('ISMainBundle:category:index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        if ($form->handleRequest($request)->isValid()) {

            $category->setCreatedAt(new \datetime);
            $category->setUpdatedAt(new \datetime);

            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La categorie a bien été enregistré !');
            return $this->redirectToRoute('category_index');
        }

        return $this->render('ISMainBundle:category:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);

        if ($form->handleRequest($request)->isValid()) {

            $category->setUpdatedAt(new \datetime);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La categorie a bien été enregistré !');
            return $this->redirectToRoute('category_index');
        }

        return $this->render('ISMainBundle:category:edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ISMainBundle:Category')->find($id);

        try{
            $em->remove($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La categorie a été supprimé.');
            return $this->redirectToRoute('category_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer cette categorie. Des donnees sont liés à cette categorie');
            return $this->redirectToRoute('category_index');
        }
    }

}