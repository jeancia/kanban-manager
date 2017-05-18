<?php

namespace SprintBundle\Controller;

use AppBundle\Controller\AbstractAppController;
use SprintBundle\Entity\Sprint;

abstract class AbstractSprintController extends AbstractAppController
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getSprintAccess()
    {
        return $this->session->get("sprint");
    }

    protected function hasSprintAccess():bool
    {
        return (bool) $this->getSprintAccess();
    }

    protected function readUserSprint()
    {
        return $this->getDoctrine()
        ->getManager()
        ->getRepository(\AuthBundle\Entity\User::class)
        ->findOneBy([
            "id" => $this->getGlobalAccess()
        ])
        ->getSprint();
    }

    protected function redirectToCreate()
    {
        return $this->redirectToRoute("create");
    }

    protected function redirectToSprint()
    {
        return $this->redirectToRoute("sprint");
    }

    protected function setSprintAccess(Sprint $sprint)
    {
        $this->session->set("sprint", $sprint->getId());
    }
    
    protected function readUser()
    {
        return $this
        ->getDoctrine()
        ->getManager()
        ->getRepository(\AuthBundle\Entity\User::class)
        ->findOneBy(
            ["id" => $this->getGlobalAccess()]
            );
    }
    
    protected function readSprint()
    {
        return $this
        ->getDoctrine()
        ->getManager()
        ->getRepository(\SprintBundle\Entity\Sprint::class)
        ->findOneBy(
            ["id" => $this->getSprintAccess()]
            );
    }
    
    protected function remove($remove)
    {
        return $this
        ->getDoctrine()
        ->getManager()
        ->remove($remove);
    }
    
    protected function flush()
    {
        return $this
        ->getDoctrine()
        ->getManager()
        ->flush();    
    }
    
    protected function setScrumMasterAccess(Sprint $sprint)
    {
        return $this->session->set(
            "master",
            $sprint->getUser()->getId() === $this->getGlobalAccess()
            );
    }
    
    protected function getScrumMasterAccess()
    {
        return $this->session->get("master");
    }
    
    protected function hasScrumMasterAccess(): bool
    {
        return (bool) $this->getScrumMasterAccess();
    }
    
}
