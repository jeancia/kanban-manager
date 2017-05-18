<?php

namespace BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/bar/{id}/{nic}", name="bar", 
     *  requirements={"id": "[0-9]{2}", "nic": "[A-Z]{1,99}"})
     */
    public function indexAction($id)
    {  
        return $this->redirectToRoute("baz");
    }
    /**
     * @Route("/baz", name="baz")
     */
    public function baz()
    {
        
        return $this->render('@BarBundle/Resources/Views/Default/index.html.twig', [
            "Hello" => "Hello Toi"
        ]);
    }
}
