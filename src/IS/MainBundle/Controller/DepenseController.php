<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\Depense;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Depense controller.
 *
 */
class DepenseController extends Controller
{
    /**
     * Lists all depense entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $from = date('Y-m-d');
        $to = date('Y-m-d');
        $depenses = $em->getRepository('ISMainBundle:Depense')->getList($from, $to);

        if($request->get('daterange') and  $request->isMethod('get') )
        {

            $string = explode('-',$request->get('daterange'));
            $date1 = explode('/',trim($string[0]));
            $date2 = explode('/',trim($string[1]));

            $finalDate1 = trim($date1[2].'-'.$date1[0].'-'.$date1[1]);
            $finalDate2 = trim($date2[2].'-'.$date2[0].'-'.$date2[1]);
            $depenses = $em->getRepository('ISMainBundle:Depense')->getList($finalDate1, $finalDate2);
           // dump($depenses); exit;

        }

        return $this->render('ISMainBundle:depense:index.html.twig', array(
            'depenses' => $depenses,
        ));
    }

    /**
     * Creates a new depense entity.
     *
     */
    public function newAction(Request $request)
    {
        $depense = new Depense();
        $form = $this->createForm('IS\MainBundle\Form\DepenseType', $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $depense->setCreatedAt(new \datetime);
            $depense->setUpdatedAt(new \datetime);
            $em->persist($depense);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La depense a été ajoutée.');
            return $this->redirectToRoute('depense_index');
        }

        return $this->render('ISMainBundle:depense:new.html.twig', array(
            'depense' => $depense,
            'form' => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing depense entity.
     *
     */
    public function editAction(Request $request, Depense $depense)
    {
        $deleteForm = $this->createDeleteForm($depense);
        $editForm = $this->createForm('IS\MainBundle\Form\DepenseType', $depense);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $depense->setUpdatedAt(new \datetime);


            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'La depense a été modifiée.');
            return $this->redirectToRoute('depense_index');
        }

        return $this->render('ISMainBundle:depense:edit.html.twig', array(
            'depense' => $depense,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a depense entity.
     *
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('ISMainBundle:Depense')->find($id);

        try{
            $em->remove($matiere);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La depense a été supprimé.');
            return $this->redirectToRoute('matiere_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer la depense. Des données sont liées à cette depense');
            return $this->redirectToRoute('matiere_index');
        }
    }

    /**
     * Creates a form to delete a depense entity.
     *
     * @param Depense $depense The depense entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Depense $depense)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('depense_delete', array('id' => $depense->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
