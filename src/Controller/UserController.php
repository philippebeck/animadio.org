<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends MainController
{
    /**
     * @var array
     */
    private $user = [];

    private function checkLogin()
    {
        $user = ModelFactory::getModel("User")->readData($this->user["email"], "email");

        if (!password_verify($this->user["pass"], $user["pass"])) {
            $this->getSession()->createAlert("Failed authentication !", "black");

            $this->redirect("user");
        }

        $this->getSession()->createSession($user);
        $this->getSession()->createAlert("Successful authentication, welcome " . $user["name"] . " !", "purple");

        $this->redirect("admin");
    }

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

            if (isset($this->user["g-recaptcha-response"]) && !empty($this->user["g-recaptcha-response"])) {

                if ($this->getSecurity()->checkRecaptcha($this->user["g-recaptcha-response"])) {
                    $this->checkLogin();
                }
            }

            $this->getSession()->createAlert("Check the reCAPTCHA !", "red");

            $this->redirect("user");
        }

        return $this->render("front/login.twig");
    }

    public function logoutMethod()
    {
        $this->getSession()->destroySession();

        $this->redirect("home");
    }

    private function setUserData()
    {
        $this->user["name"]     = $this->getPost()->getPostVar("name");
        $this->user["email"]    = $this->getPost()->getPostVar("email");
    }

    private function setUserImage()
    {
        $this->user["image"] = $this->getString()->cleanString($this->user["name"]) . $this->getFiles()->setFileExtension();

        $this->getFiles()->uploadFile("img/user/", $this->getString()->cleanString($this->user["name"]));
        $this->getImage()->makeThumbnail("img/user/" . $this->user["image"], 150);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setUserData();
            $this->setUserImage();

            if ($this->getPost()->getPostVar("pass") !== $this->getPost()->getPostVar("conf-pass")) {
                $this->getSession()->createAlert("Passwords do not match !", "red");

                $this->redirect("user!create");
            }

            $this->user["pass"] = password_hash($this->getPost()->getPostVar("pass"), PASSWORD_DEFAULT);

            ModelFactory::getModel("User")->createData($this->user);
            $this->getSession()->createAlert("New user successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/user/createUser.twig");
    }

    private function setUpdatePassword()
    {
        $user = ModelFactory::getModel("User")->readData($this->getGet()->getGetVar("id"));

        if (!password_verify($this->getPost()->getPostVar("old-pass"), $user["pass"])) {
            $this->getSession()->createAlert("Old Password does not match !", "red");

            $this->redirect("admin");
        }

        if ($this->getPost()->getPostVar("new-pass") !== $this->getPost()->getPostVar("conf-pass")) {
            $this->getSession()->createAlert("New Passwords do not match !", "red");

            $this->redirect("admin");
        }

        $this->user["pass"] = password_hash($this->getPost()->getPostVar("new-pass"), PASSWORD_DEFAULT);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setUserData();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setUserImage();
            }

            if (!empty($this->getPost()->getPostVar("old-pass"))) {
                $this->setUpdatePassword();
            }

            ModelFactory::getModel("User")->updateData($this->getGet()->getGetVar("id"), $this->user);
            $this->getSession()->createAlert("Successful modification of the user !", "blue");

            $this->redirect("admin");
        }

        $user = ModelFactory::getModel("User")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/user/updateUser.twig", ["user" => $user]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("User")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("User actually deleted !", "red");

        $this->redirect("admin");
    }
}
