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
        if (!empty($this->getPost()->getPostArray())) {
            $mail = $this->getPost()->getPostArray();

            if (isset($mail["g-recaptcha-response"]) && !empty($mail["g-recaptcha-response"])) {

                if ($this->getSecurity()->checkRecaptcha($mail["g-recaptcha-response"])) {
                    $this->getMail()->sendMessage($mail);
                    $this->getSession()->createAlert("Message successfully sent to " . MAIL_USERNAME . " !", "green");

                    $this->redirect("home");
                }
            }

            $this->getSession()->createAlert("Check the reCAPTCHA !", "red");

            $this->redirect("contact");
        }

        return $this->render("front/contact.twig");
    }
}
