<?php

namespace IS\MainBundle\Controller;

use IS\MainBundle\Entity\Client;
use IS\MainBundle\Entity\MatierePremiere;
use IS\MainBundle\Entity\Product;
use IS\MainBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ClientController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('ISMainBundle:Client')->findAll();

        return $this->render('ISMainBundle:client:index.html.twig', array(
            'clients' => $client,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);


        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $client->setCreatedAt(new \datetime);
            $client->setUpdatedAt(new \datetime);

            $em->persist($client);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le client a bien été enregistrée !');
            return $this->redirectToRoute('client_index');
        }

        return $this->render('ISMainBundle:client:new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }



    public function editAction(Request $request, Client $client)
    {

        $form = $this->createForm(ClientType::class, $client);


        if ($form->handleRequest($request)->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le client a bien été enregistré !');
            return $this->redirectToRoute('client_index');
        }

        return $this->render('ISMainBundle:client:edit.html.twig', array(
            'matiere' => $client,
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
        $client = $em->getRepository('ISMainBundle:Client')->find($id);

        try{
            $em->remove($client);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le client a été supprimé.');
            return $this->redirectToRoute('client_index');
        }catch(\Exception $e){
            $request->getSession()->getFlashBag()->add('warning', 'Impossible de supprimer le client. Des données sont liées à ce client');
            return $this->redirectToRoute('client_index');
        }
    }


}
