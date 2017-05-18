<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AbstractAppController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('@AppBundle/Resources/views/document.html.twig',
            [
                "global_access" => $this->hasGlobalAccess()
            ]
            );
    }
}
