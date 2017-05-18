<?php

namespace AuthBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AuthBundle\Entity\User;
use Throwable;

class JoinController extends AbstractAuthController
{

    const  /**
    * @var string error message for authentification
    */
    ERROR_MESSAGE_JOIN ="Account already exists";
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @Route("/join", name="join")
     */
    public function joinAction(Request $request)
    {
        if ($this->hasGlobalAccess()) {
            return $this->redirectToRoute("homepage");
        }    
        $form = $this->getAuthAndJoinForm("Create an account");
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->readUser($form)) {
                $user = new User();
                $user->setEmail($form->getData()["email"]);
                $user->setPassword(
                    password_hash($form->getData()["password"], 
                        PASSWORD_DEFAULT));
                //$this->setGlobalAccess("id", $user->getId());
                try {
                    $this->getDoctrine()->getManager()->persist($user);
                    $this->getDoctrine()->getManager()->flush();
                } catch (Throwable $e) {
                    $message = "An error has occured";
                }
                $this->setGlobalAccess($user);
                return $this->redirectToHomePage();
            } else {
                $message = "Account already exists";
            }
        }
        return $this->render(
            '@AuthBundle/Resources/views/sign.html.twig', [
                "title" => "Sign up",
                "form" => $form->createView(),
                "legend" => "Already an account? Please",
                "link" => "Sign in",
                "url" => $this->generateUrl("auth"),
                "message" => isset($message) ? $message : ""
                ]
            );
        }
}
