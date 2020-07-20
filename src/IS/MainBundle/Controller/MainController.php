<?php
/**
 * Created by PhpStorm.
 * User: MPHASIS
 * Date: 05/07/2020
 * Time: 21:08
 */

namespace IS\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('ISMainBundle::index.html.twig');
    }

    public function stockAction()
    {
        return $this->render('ISMainBundle::stock.html.twig');
    }

}