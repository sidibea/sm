<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\Category;
use IS\MainBundle\Entity\Product;
use IS\MainBundle\Entity\Variation;
use IS\MainBundle\Form\ProductEditType;
use IS\MainBundle\Form\ProductType;
use IS\MainBundle\Form\VariationEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ISMainBundle:Product')->findAll();
        $categories = $em->getRepository('ISMainBundle:Category')->findAll();

        return $this->render('ISMainBundle:product:index.html.twig', array(
            'products' => $products,
            'categories' => $categories,
        ));
    }

   public function byCategoryAction(Category $category)
   {
       $em = $this->getDoctrine()->getManager();

       $products = $em->getRepository('ISMainBundle:Product')->findBy([
           'category' => $category
       ]);

       return $this->render('ISMainBundle:product:element.html.twig', array(
           'products' => $products,
       ));
   }
    public function byCategoryPAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ISMainBundle:Product')->findBy([
            'category' => $category
        ]);

        return $this->render('ISMainBundle:product:element1.html.twig', array(
            'products' => $products,
        ));
    }
    public function byCategoryPEAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ISMainBundle:Product')->findBy([
            'category' => $category
        ]);

        return $this->render('ISMainBundle:product:element2.html.twig', array(
            'products' => $products,
        ));
    }

   public function newAction(Request $request)
   {
       $product = new Product();
       $form = $this->createForm(ProductType::class, $product);


       if ($form->handleRequest($request)->isValid()) {
           $em = $this->getDoctrine()->getManager();

           $product->setCreatedAt(new \datetime);
           $product->setUpdatedAt(new \datetime);

           $em->persist($product);
           $em->flush();

           $request->getSession()->getFlashBag()->add('notice', 'Le produit a bien été enregistré !');
           return $this->redirectToRoute('product_index');
       }

       return $this->render('ISMainBundle:product:new.html.twig', array(
           'product' => $product,
           'form' => $form->createView(),
       ));

   }


    public function editAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);


        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $product->setCreatedAt(new \datetime);
            $product->setUpdatedAt(new \datetime);

            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le produit a bien été enregistré !');
            return $this->redirectToRoute('product_index');
        }

        return $this->render('ISMainBundle:product:edit.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));

    }

    public function variationsAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('ISMainBundle:product:variations.html.twig', array(
            'product' => $product

        ));

    }

    public function variationsEditAction(Request $request, Product $product, Variation $variation)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(VariationEditType::class, $variation);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'La composition a bien été enregistrée !');
            return $this->redirectToRoute('product_variations', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('ISMainBundle:product:variationsEdit.html.twig', array(
            'form' => $form->createView(),
            'product' => $product,
            'variation' => $variation
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ISMainBundle:Product')->find($id);

        try{
            $em->remove($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le produit a été supprimé.');
            return $this->redirectToRoute('product_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer ce produit. Des articles sont liés à ce produit');
            return $this->redirectToRoute('product_index');
        }
    }

    public function variationsDeleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //dump($id); exit;
        $product = $em->getRepository('ISMainBundle:Variation')->find($id);

        try{
            $em->remove($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La a été supprimé.');
            return $this->redirectToRoute('product_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer cette variation. Des articles sont liés à ce produit');
            return $this->redirectToRoute('product_index');
        }
    }
}
