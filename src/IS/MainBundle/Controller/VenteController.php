<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\Panier;
use IS\MainBundle\Entity\Product;
use IS\MainBundle\Entity\StockPortion;
use IS\MainBundle\Entity\Taille;
use IS\MainBundle\Entity\Variation;
use IS\MainBundle\Entity\Vente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Vente controller.
 *
 */
class VenteController extends Controller
{
    /**
     * Lists all vente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ventes = $em->getRepository('ISMainBundle:Vente')->findBy([
        	"isValid" => true,
        	'saleBy' => $this->getUser()
        ],[
            'createdAt' => 'desc'
        ]);

        return $this->render('ISMainBundle:vente:index.html.twig', array(
            'ventes' => $ventes,
        ));
    }
    public function changeQteAction($panier, $qte){

        $em = $this->getDoctrine()->getManager();

        $panier = $em->getRepository('ISMainBundle:Panier')->find($panier);
        $panier->setQte($qte);
        $em->flush();

        return $this->Json([
            'success' => true,
            'panier' => $qte

        ]);


    }


    public function receiptAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $vente = $em->getRepository('ISMainBundle:Vente')->find($id);

       // dump($vente); exit;

        return $this->render('ISMainBundle:vente:receipt.html.twig', array(
            'vente' => $vente,
        ));
    }

    /**
     * Creates a new vente entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('ISMainBundle:Client')->findAll();

            //dump($last); exit;
        $panier = $em->getRepository('ISMainBundle:Panier')->findBy([
            'user' => $this->getUser(),
            'vente' => null
        ]);
        $categories = $em->getRepository('ISMainBundle:Category')->findAll();


        return $this->render('ISMainBundle:vente:new.html.twig', array(
            'categories' => $categories,
            'panier' => $panier,
            'clients' => $clients

        ));
    }

    public function deletePanierAction(Request $request, Panier $panier)
    {
        $em = $this->getDoctrine()->getManager();

        try{
            $em->remove($panier);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le produit a été supprimé du panier.');
            return $this->redirectToRoute('vente_new');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer ce panier. Des données sont liées à cette vente');
            return $this->redirectToRoute('vente_new');
        }
    }


    public function addVariationAction($panier, $variations)
    {

        $em = $this->getDoctrine()->getManager();
        $panier = $em->getRepository('ISMainBundle:Panier')->find($panier);
        $variation = $em->getRepository('ISMainBundle:Variation')->find($variations);
        $panier->setVariation($variation);
        $em->flush();


         return $this->Json([
             'success' => true,
             'prix' => $variation->getPrix()

         ]);




    }

    public function addpanierAction(Product $product)
    {
        //$serializer = $this->container->get('serializer');

        $cart = new Panier();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ISMainBundle:Product')->find($product);
        $variations = $product->getVariations();
        $cart->setProducts($product);
        $cart->setQte(1);
        $cart->setUser($this->getUser());
        $em->persist($cart);
        $em->flush();
        return  $this->json([
            'success' => true,
        ]);
           /* return $this->Json([
                'success' => true,
                'products' => [
                    'id' => $product->getId(),
                    'nom' => $product->getNom(),
                    'variations' => [
                        'id' => $variations->getNom()
                    ]
                ]
            ]);*/



    }
    public function editPanierAction($id, $vente)
    {
        //$serializer = $this->container->get('serializer');

        $cart = new Panier();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ISMainBundle:Product')->find($id);
        $v = $em->getRepository('ISMainBundle:Vente')->find($vente);
        $variations = $product->getVariations();
        $cart->setProducts($product);
        $cart->setVente($v);
        $cart->setUser($this->getUser());
        $em->persist($cart);
        $em->flush();
        return  $this->json([
            'success' => true,
        ]);
           /* return $this->Json([
                'success' => true,
                'products' => [
                    'id' => $product->getId(),
                    'nom' => $product->getNom(),
                    'variations' => [
                        'id' => $variations->getNom()
                    ]
                ]
            ]);*/



    }
    public function validationAction($client, $table, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('ISMainBundle:Client')->find($client);

        $vente = new Vente();

        $panier = $em->getRepository('ISMainBundle:Panier')->findBy([
            'user' => $this->getUser(),
            'vente' => null
        ]);


        $vente->setClient($clients);
        $vente->setSaleBy($this->getUser());
        $vente->setTable($table);
        $vente->setIsValid(true);

        $vente->setCreatedAt(new \datetime);
        $vente->setUpdatedAt(new \datetime);

        $em->persist($vente);

        $em->flush();

        foreach($panier as $p)
        {
            $vente->addPanier($p);
            $p->setVente($vente);
            $vente->addPanier($p);
        }

        $em->flush();

        foreach ( $vente->getPaniers() as $l )
        {
            foreach($l->getProducts()->getVariations() as $vv)
            {
                if($vv == $l->getVariation())
                {
                    foreach($vv->getCompositions() as $c)
                    {
                        for($i=0; $i<$l->getQte(); $i++)
                        {
                            $stockP = new StockPortion();
                            $stockP->setProduit($c->getMatiere());
                            $stockP->setTaille($l->getVariation()->getTaille()->getNom());
                            $stockP->setQte($c->getQte());
                            $stockP->setType('out');
                            $stockP->setVente($vente);

                            $stockP->setCreatedAt(new \datetime);
                            $stockP->setUpdatedAt(new \datetime);
                            $em->persist($stockP);
                            $em->flush();
                        }
                    }
                }


            }

        }

        return  $this->json([
            'success' => true,
            'vente' => $vente->getId()
        ]);



    }
    public function validationEditAction($client, $table, $vente, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('ISMainBundle:Client')->find($client);

        $vente = $em->getRepository('ISMainBundle:Vente')->find($vente);

        $panier = $em->getRepository('ISMainBundle:Panier')->findBy([
            'user' => $this->getUser(),
            'vente' => $vente
        ]);


        $vente->setClient($clients);
        $vente->setSaleBy($this->getUser());
        $vente->setTable($table);
        $vente->setIsValid(true);

        $vente->setCreatedAt(new \datetime);
        $vente->setUpdatedAt(new \datetime);


        $em->flush();

        foreach($panier as $p)
        {
            $vente->addPanier($p);
            $vente->addPanier($p);
        }

        $em->flush();

        foreach ( $vente->getPaniers() as $l )
        {
            foreach($l->getProducts()->getVariations() as $vv)
            {
                if($vv == $l->getVariation())
                {
                    foreach($vv->getCompositions() as $c)
                    {
                        $stockP = new StockPortion();
                        $stockP->setProduit($c->getMatiere());
                        $stockP->setTaille($l->getVariation()->getTaille()->getNom());
                        $stockP->setQte($c->getQte());
                        $stockP->setType('out');
                        $stockP->setVente($vente);

                        $stockP->setCreatedAt(new \datetime);
                        $stockP->setUpdatedAt(new \datetime);
                        $em->persist($stockP);
                        $em->flush();
                    }
                }


            }

        }

        return  $this->json([
            'success' => true,
            'vente' => $vente->getId()
        ]);



    }

    /**
     * Finds and displays a vente entity.
     *
     */
    public function showAction(Vente $vente)
    {
        $deleteForm = $this->createDeleteForm($vente);

        return $this->render('vente/show.html.twig', array(
            'vente' => $vente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vente entity.
     *
     */
    public function editAction(Request $request, Vente $vente)
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('ISMainBundle:Client')->findAll();

        //dump($last); exit;
        $panier = $em->getRepository('ISMainBundle:Panier')->findBy([
            'user' => $this->getUser(),
            'vente' => $vente
        ]);
        $categories = $em->getRepository('ISMainBundle:Category')->findAll();


        return $this->render('ISMainBundle:vente:edit.html.twig', array(
            'categories' => $categories,
            'panier' => $panier,
            'clients' => $clients,
            'vente' => $vente

        ));
    }

    /**
     * Deletes a vente entity.
     *
     */
    public function deleteAction(Request $request, Vente $vente)
    {
        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('ISMainBundle:Vente')->find($vente);

        try{
            $em->remove($matiere);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La vente a été supprimé.');
            return $this->redirectToRoute('vente_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer cette vente. Des données sont liées à cette vente');
            return $this->redirectToRoute('vente_index');
        }
    }





}
