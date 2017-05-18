<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\Request;
use AuthBundle\Entity\User;

class AuthController extends AbstractAuthController
{
    const 
         /**
          * @var string error message for authentification
          */
        ERROR_MESSAGE_AUTH ="Incorrect email or password";
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @Route ("/auth", name="auth")
     */
    public function authAction(Request $request)
    {
        if ($this->hasGlobalAccess()) {
            return $this->redirectToRoute("homepage");
        }
        $form = $this->getAuthAndJoinForm("Sign in");
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $user = $this->readUser($form);
            if ($user 
                && password_verify($form->getData()["password"],
                    $user->getPassword() )) {
                        $this->setGlobalAccess($user);
                        return $this->redirectToRoute("homepage");
                    }
            }
            
            $message = self::ERROR_MESSAGE_AUTH;
        
        
        return $this->render("@AuthBundle/Resources/views/sign.html.twig", [
            "title"=> "Sign in",
            "form"=> $form->createView(),
            "legend"=> "New to sprint.io",
            "link"=>"Sign in",
            "url" =>$this->generateUrl("join"),
            "message"=> isset($message) ? $message : ""
        ]);
    }
}
