<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ClassController
 * @package App\Controller
 */
class ClassController extends MainController
{
    /**
     * @var array
     */
    private $class = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $this->redirect("doc");
    }

    private function setClassData()
    {
        $this->class["name"] = (string) trim($this->getPost("name"));

        $this->class["category_id"] = (int) $this->getPost("category_id");
        $this->class["media"]       = (int) $this->getPost("media");
        $this->class["concat"]      = (int) $this->getPost("concat");
        $this->class["state_id"]    = (int) $this->getPost("state_id");
    }

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
            $this->setClassData();

            ModelFactory::getModel("Class")->createData($this->class);

            $this->setSession([
                "message"   => "New Class successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("ClassCat")->listData();
        $states     = ModelFactory::getModel("ClassState")->listData();

        return $this->render("back/createClass.twig", [
            "categories"    => $categories,
            "states"        => $states
        ]);
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
            $this->setClassData();

            ModelFactory::getModel("Class")->updateData(
                $this->getGet("id"), 
                $this->class
            );

            $this->setSession([
                "message"   => "Successful modification of the Class !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $class      = ModelFactory::getModel("Class")->readData($this->getGet("id"));
        $categories = ModelFactory::getModel("ClassCat")->listData();
        $states     = ModelFactory::getModel("ClassState")->listData();

        return $this->render("back/updateClass.twig", [
            "class"         => $class,
            "categories"    => $categories,
            "states"        => $states
        ]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Class")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Class actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
