<?php
/**
 * Created by PhpStorm.
 * User: MPHASIS
 * Date: 29/06/2020
 * Time: 10:37
 */

namespace IS\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RapportController extends Controller
{
    public function indexAction()
    {
        return $this->render('ISMainBundle:rapport:index.html.twig');
    }
    public function stockPortionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entree = $em->getRepository('ISMainBundle:StockPortion')->getReportIN();
        $sortie = $em->getRepository('ISMainBundle:StockPortion')->getReportOUT();
        $reel = $em->getRepository('ISMainBundle:StockPortion')->getReportReel();



        return $this->render('ISMainBundle:rapport:stockPortion.html.twig', [
            'entrees' => $entree,
            'sorties' => $sortie,
            'reel' => $reel
        ]);

    }
    public function stockPortion2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $entree = $em->getRepository('ISMainBundle:StockPortion')->getReport();




        return $this->render('ISMainBundle:rapport:stockPortion2.html.twig', [
            'stocks' => $entree,

        ]);

    }

    public function stockMatiereAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('ISMainBundle:StockMatiere')->getReport();
        return $this->render('ISMainBundle:rapport:stockMatiere.html.twig', [
            'stock' => $stock
        ]);

    }
    public function achatMatiereAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('ISMainBundle:AchatMarchandise')->getReport();
        return $this->render('ISMainBundle:rapport:achatMarchandise.html.twig', [
            'achat' =>  $stock
        ]);
    }

}