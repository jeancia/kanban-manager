<?php

namespace SprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DeleteController extends AbstractSprintController
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @Route("/delete", name="delete")
     */
    public function deleteAction()
    {
        if (!$this->hasGlobalAccess()) {
            return $this->redirectToHome();
        } else if (!$this->hasScrumMasterAccess() 
            || !$this->hasSprintAccess()) {
            return $this->redirectToSprint();
        }
        
        
        
        $userCollection = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(\AuthBundle\Entity\User::class)
            ->findBy([
                "sprint" =>$this->getSprintAccess() 
        ]);
            foreach ($userCollection as $user) {
            $user->setSprint(null);
            $this
                ->getDoctrine()
                ->getManager()
                ->flush();
        }
        
//         $user = $sprint->getUser();
        $sprint = $this->readSprint();
        $sprint->getUser()->setSprint(null);
        $this->flush();
        $this->remove($sprint);
        $this->flush();
        $this->session->remove("sprint");
        $this->session->remove("master");
        return $this->redirectToCreate();
        
        
//          $user = $sprint->getUser();
//         $user->setSprint(null);
//         $user->remove($sprint);
        

       
        
        
        
    }
}
