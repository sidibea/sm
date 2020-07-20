<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\MatierePremiere;
use IS\MainBundle\Entity\Product;
use IS\MainBundle\Form\MatierePremiereType;
use IS\MainBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class MatiereController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matiere = $em->getRepository('ISMainBundle:MatierePremiere')->findAll();

        return $this->render('ISMainBundle:matiere:index.html.twig', array(
            'matieres' => $matiere,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $matiere = new MatierePremiere();
        $form = $this->createForm(MatierePremiereType::class, $matiere);


        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $matiere->setCreatedAt(new \datetime);
            $matiere->setUpdatedAt(new \datetime);

            $em->persist($matiere);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La matière première a bien été enregistrée !');
            return $this->redirectToRoute('matiere_index');
        }

        return $this->render('ISMainBundle:matiere:new.html.twig', array(
            'product' => $matiere,
            'form' => $form->createView(),
        ));
    }



    public function editAction(Request $request, MatierePremiere $matiere)
    {

        $form = $this->createForm(MatierePremiereType::class, $matiere);


        if ($form->handleRequest($request)->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La matière première a bien été enregistré !');
            return $this->redirectToRoute('matiere_index');
        }

        return $this->render('ISMainBundle:matiere:edit.html.twig', array(
            'matiere' => $matiere,
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
        $matiere = $em->getRepository('ISMainBundle:MatierePremiere')->find($id);

        try{
            $em->remove($matiere);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La matière a été supprimé.');
            return $this->redirectToRoute('matiere_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer la matière première. Des données sont liées à cette matière');
            return $this->redirectToRoute('matiere_index');
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
