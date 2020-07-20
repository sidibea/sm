<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\AchatMarchandise;
use IS\MainBundle\Entity\MatierePremiere;
use IS\MainBundle\Entity\Product;
use IS\MainBundle\Entity\StockMatiere;
use IS\MainBundle\Entity\StockPortion;
use IS\MainBundle\Form\AchatMarchandiseType;
use IS\MainBundle\Form\MatierePremiereType;
use IS\MainBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class AchatMarchandiseController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $achat = $em->getRepository('ISMainBundle:AchatMarchandise')->findAll();

        return $this->render('ISMainBundle:achatmarchandise:index.html.twig', array(
            'achatMarchandises' => $achat,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $achat = new AchatMarchandise();
        $form = $this->createForm(AchatMarchandiseType::class, $achat);
        $patte = $em->getRepository('ISMainBundle:MatierePremiere')->find(37);
        $crepe = $em->getRepository('ISMainBundle:MatierePremiere')->find(21);


        if ($form->handleRequest($request)->isValid()) {
            $achat->setCreatedAt(new \datetime);
            $achat->setUpdatedAt(new \datetime);

            $em->persist($achat);
            $em->flush();

            $stock = new StockMatiere();
            $stock->setProduit($achat->getMatiere());
            $stock->setAchat($achat);
            $stock->setMontant($achat->getPrix());
            $stock->setQte($achat->getQte());
            $stock->setType('in');
            $stock->setCreatedAt(new \datetime);
            $stock->setUpdatedAt(new \datetime);
            $em->persist($stock);
            $em->flush();

            if($achat->getMatiere() == $patte)
            {
                for($i = 0; $i<4; $i++)
                {
                    $stocks = new StockPortion();
                    $stocks->setProduit($crepe);
                    $stocks->setQte(4 * $achat->getQte());
                    $stocks->setType('in');
                    $stocks->setCreatedAt(new \datetime);
                    $stocks->setUpdatedAt(new \datetime);
                    $em->persist($stocks);
                    $em->flush();
                }
            }

            $request->getSession()->getFlashBag()->add('notice', 'L\'achat a bien été enregistrée !');
            return $this->redirectToRoute('achatmarchandise_index');
        }

        return $this->render('ISMainBundle:achatmarchandise:new.html.twig', array(
            'achat' => $achat,
            'form' => $form->createView(),
        ));
    }



    public function editAction(Request $request, AchatMarchandise $achat)
    {

        $form = $this->createForm(AchatMarchandiseType::class, $achat);


        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $achat->setUpdatedAt(new \datetime);

            $em->flush();

            $stock = $em->getRepository('ISMainBundle:StockMatiere')->findOneBy([
                'achat' => $achat
            ]);
            $stock->setProduit($achat->getMatiere());
            $stock->setAchat($achat);
            $stock->setMontant($achat->getPrix());
            $stock->setQte($achat->getQte());
            $stock->setType('in');
            $stock->setCreatedAt(new \datetime);
            $stock->setUpdatedAt(new \datetime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'L\'achat a bien été enregistrée !');
            return $this->redirectToRoute('achatmarchandise_index');
        }

        return $this->render('ISMainBundle:achatmarchandise:edit.html.twig', array(
            'achat' => $achat,
            'form' => $form->createView(),

        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('ISMainBundle:AchatMarchandise')->find($id);

        try{
            $em->remove($matiere);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'L\'achat a été supprimé.');
            return $this->redirectToRoute('achatmarchandise_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer cet achat. Des données sont liées à cet achat');
            return $this->redirectToRoute('achatmarchandise_index');
        }
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $matiere The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $matiere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $matiere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
