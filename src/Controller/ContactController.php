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
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkArray($this->getPost())) {
            $mail = $this->getPost();

            if (isset($mail["g-recaptcha-response"]) && !empty($mail["g-recaptcha-response"])) {
                
                if ($this->checkRecaptcha($mail["g-recaptcha-response"])) {
                    $this->sendMail($mail);

                    $this->setSession([
                        "message"   => "Message successfully sent to " . MAIL_USERNAME . " !", 
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

        return $this->render("front/contact.twig");
    }
}
