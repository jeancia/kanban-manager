<?php

namespace SprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SprintController extends AbstractSprintController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Route("/sprint", name="sprint")
     */
    
    public function sprintAction()
    {
        if (!$this->hasGlobalAccess()) {
            return $this->redirectToHome();
        } else if (!$this->hasSprintAccess()) {
            return $this->redirectToCreate();
        } 
        
        
        $user = $this->readUser();
        $sprint = $this->readSprint();
        $lapsed = (time() - $sprint->getTime());
        $duration = $sprint->getDay() * 86400;
        ;
        

        
        
        return $this->render("@SprintBundle/Resources/views/sprint.html.twig", [
            "goal" => $sprint->getGoal(),
            "description" => $sprint->getDescription(),
            "day" => $sprint->getDay(),
            "percent" => (round($lapsed / $sprint->getDay() * 100, 2)),
            "master_access" => $this->hasScrumMasterAccess(),
        ]);
        
        
    }
}
