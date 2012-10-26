<?php

namespace Checker\LBCCheckerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LBCCheckerBundle:Default:index.html.twig', array('name' => $name));
    }
}
