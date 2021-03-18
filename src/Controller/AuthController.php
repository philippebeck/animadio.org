<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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
        if (!empty($this->getPost()->getPostArray())) {
            $this->user = $this->getPost()->getPostArray();
            $this->checkSecurity();
        }

        return $this->render("front/login.twig");
    }

    private function checkSecurity()
    {
        if (isset($this->user["g-recaptcha-response"]) && !empty($this->user["g-recaptcha-response"])) {

            if ($this->getSecurity()->checkRecaptcha($this->user["g-recaptcha-response"])) {
                $this->checkLogin();
            }
        }

        $this->getSession()->createAlert("Check the reCAPTCHA !", "red");

        $this->redirect("auth");
    }

    private function checkLogin()
    {
        $user = ModelFactory::getModel("User")->readData($this->user["email"], "email");

        if (!password_verify($this->user["pass"], $user["pass"])) {
            $this->getSession()->createAlert("Failed authentication !", "black");

            $this->redirect("auth");
        }

        $this->getSession()->createSession($user);
        $this->getSession()->createAlert("Successful authentication, welcome " . $user["name"] . " !", "violet");

        $this->redirect("admin");
    }

    public function logoutMethod()
    {
        $this->getSession()->destroySession();

        $this->redirect("home");
    }
}
