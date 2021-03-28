<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class VariableController
 * @package App\Controller
 */
class VariableController extends MainController
{
    /**
     * @var array
     */
    private $variable = [];

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
            $this->setVariableData();

            ModelFactory::getModel("Variable")->createData($this->variable);
            $this->getSession()->createAlert("New variable successfully created !", "green");

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("VariableCat")->listData();

        return $this->render("back/variable/createVariable.twig", [
            "categories" => $categories
        ]);
    }

    private function setVariableData()
    {
        $this->variable["name"]         = (string) trim($this->getPost()->getPostVar("name"));
        $this->variable["category_id"]  = (int) $this->getPost()->getPostVar("category_id");
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
            $this->setVariableData();

            ModelFactory::getModel("Variable")->updateData($this->getGet()->getGetVar("id"), $this->variable);
            $this->getSession()->createAlert("Successful modification of the variable !", "blue");

            $this->redirect("admin");
        }

        $variable   = ModelFactory::getModel("Variable")->readData($this->getGet()->getGetVar("id"));
        $categories = ModelFactory::getModel("VariableCat")->listData();

        return $this->render("back/variable/updateVariable.twig", [
            "variable"      => $variable,
            "categories"    => $categories
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Variable")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Variable actually deleted !", "red");

        $this->redirect("admin");
    }
}
