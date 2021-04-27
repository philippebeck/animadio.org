<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends MainController
{
    /**
     * @var array
     */
    private $user = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkArray($this->getPost())) {
            $this->user = $this->getPost();

            $this->checkSecurity();
        }

        return $this->render("front/login.twig");
    }

    private function checkSecurity()
    {
        if (isset($this->user["g-recaptcha-response"]) && !empty($this->user["g-recaptcha-response"])) {
            if ($this->checkRecaptcha($this->user["g-recaptcha-response"])) {
                
                $this->checkLogin();
            }
        }

        $this->setSession([
            "message"   => "Check the reCAPTCHA !", 
            "type"      => "red"
        ]);

        $this->redirect("auth");
    }

    private function checkLogin()
    {
        $user = ModelFactory::getModel("User")->readData($this->user["email"], "email");

        if (!password_verify($this->user["pass"], $user["pass"])) {
            
            $this->setSession([
                "message"   => "Failed authentication !", 
                "type"      => "black"
            ]);

            $this->redirect("auth");
        }

        $this->setSession($user);

        $this->setSession([
            "message"   => "Successful authentication, welcome " . $user["name"] . " !", 
            "type"      => "violet"
        ]);

        $this->redirect("admin");
    }

    public function logoutMethod()
    {
        $this->destroyGlobal();

        $this->redirect("home");
    }
}
