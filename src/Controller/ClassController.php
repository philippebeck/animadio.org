<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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
            $this->setClassData();

            ModelFactory::getModel("Class")->createData($this->class);
            $this->getSession()->createAlert("New class successfully created !", "green");

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("ClassCat")->listData();
        $states     = ModelFactory::getModel("ClassState")->listData();

        return $this->render("back/class/createClass.twig", [
            "categories"    => $categories,
            "states"        => $states
        ]);
    }

    private function setClassData()
    {
        $this->class["name"] = (string) trim($this->getPost()->getPostVar("name"));

        $this->class["category_id"] = (int) $this->getPost()->getPostVar("category_id");
        $this->class["media"]       = (int) $this->getPost()->getPostVar("media");
        $this->class["concat"]      = (int) $this->getPost()->getPostVar("concat");
        $this->class["state_id"]    = (int) $this->getPost()->getPostVar("state_id");
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
            $this->setClassData();

            ModelFactory::getModel("Class")->updateData($this->getGet()->getGetVar("id"), $this->class);
            $this->getSession()->createAlert("Successful modification of the class !", "blue");

            $this->redirect("admin");
        }

        $class      = ModelFactory::getModel("Class")->readData($this->getGet()->getGetVar("id"));
        $categories = ModelFactory::getModel("ClassCat")->listData();
        $states     = ModelFactory::getModel("ClassState")->listData();

        return $this->render("back/class/updateClass.twig", [
            "class"         => $class,
            "categories"    => $categories,
            "states"        => $states
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Class")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Class actually deleted !", "red");

        $this->redirect("admin");
    }
}
