<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends MainController
{
    /**
     * @var array
     */
    private $mail = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkArray($this->getPost())) {

            $this->mail = $this->getPost();
            $this->checkSecurity();
        }

        return $this->render("front/contact.twig");
    }

    private function checkSecurity()
    {
        if (isset($this->mail["g-recaptcha-response"]) && !empty($this->mail["g-recaptcha-response"])) {
            if ($this->checkRecaptcha(

                $this->mail["g-recaptcha-response"])) {
                $this->sendMail($this->mail);

                $this->setSession([
                    "message"   => "Message sent successfully to " . MAIL_USERNAME . " !",
                    "type"      => "green"
                ]);

                $this->redirect("home");
            }
        }

        $this->setSession([
            "message"   => "Check the reCAPTCHA !", 
            "type"      => "red"
        ]);

        $this->redirect("contact");
    }
}