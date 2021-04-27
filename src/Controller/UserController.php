<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $this->redirect("auth");
    }

    // ******************** SETTERS ******************** \\

    private function setUserData()
    {
        $this->user["name"]     = (string) trim($this->getPost("name"));
        $this->user["email"]    = (string) trim($this->getPost("email"));
    }

    private function setUserImage()
    {
        $this->user["image"] = $this->getString($this->user["name"]) . $this->getExtension();

        $this->getUploadedFile("img/user/", $this->getString($this->user["name"]));
        $this->getThumbnail("img/user/" . $this->user["image"], 150);
    }

    private function setUpdateData()
    {
        $this->setUserData();

        if ($this->checkArray($this->getFiles(), "name")) {
            $this->setUserImage();
        }

        if ($this->checkArray($this->getPost(), "old-pass")) {
            $this->setUpdatePassword();
        }

        ModelFactory::getModel("User")->updateData(
            $this->getGet("id"), 
            $this->user
        );

        $this->setSession([
            "message"   => "Successful modification of the user !", 
            "type"      => "blue"
        ]);

        $this->redirect("admin");
    }

    private function setUpdatePassword()
    {
        $user = ModelFactory::getModel("User")->readData($this->getGet("id"));

        if (!password_verify($this->getPost("old-pass"), $user["pass"])) {
            
            $this->setSession([
                "message"   => "Old Password does not match !", 
                "type"      => "red"
            ]);

            $this->redirect("admin");
        }

        if ($this->getPost("new-pass") !== $this->getPost("conf-pass")) {
            
            $this->setSession([
                "message"   => "New Passwords do not match !", 
                "type"      => "red"
            ]);

            $this->redirect("admin");
        }

        $this->user["pass"] = password_hash(
            $this->getPost("new-pass"), 
            PASSWORD_DEFAULT
        );
    }

    // ******************** CRUD ******************** \\

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {

            $this->setUserData();
            $this->setUserImage();

            if ($this->getPost("pass") !== $this->getPost("conf-pass")) {

                $this->setSession([
                    "message"   => "Passwords do not match !", 
                    "type"      => "red"
                ]);

                $this->redirect("user!create");
            }

            $this->user["pass"] = password_hash(
                $this->getPost("pass"), 
                PASSWORD_DEFAULT
            );

            ModelFactory::getModel("User")->createData($this->user);
            
            $this->setSession([
                "message"   => "New user successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createUser.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {
            $this->setUpdateData();
        }

        $user = ModelFactory::getModel("User")->readData($this->getGet("id"));

        return $this->render("back/updateUser.twig", ["user" => $user]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("User")->deleteData($this->getGet("id"));

        $this->SetSession([
            "message"   => "User actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}