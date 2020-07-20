<?php

namespace IS\VendeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ISVendeurBundle:Default:index.html.twig');
    }
}
