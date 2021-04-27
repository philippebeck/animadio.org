<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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

    private function setVariableData()
    {
        $this->variable["name"]         = (string) trim($this->getPost("name"));
        $this->variable["category_id"]  = (int) $this->getPost("category_id");
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
            $this->setVariableData();

            ModelFactory::getModel("Variable")->createData($this->variable);

            $this->setSession([
                "message"   => "New variable successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("VariableCat")->listData();

        return $this->render("back/createVariable.twig", ["categories" => $categories]);
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
            $this->setVariableData();

            ModelFactory::getModel("Variable")->updateData(
                $this->getGet("id"), 
                $this->variable
            );
            
            $this->setSession([
                "message"   => "Successful modification of the variable !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $variable   = ModelFactory::getModel("Variable")->readData($this->getGet("id"));
        $categories = ModelFactory::getModel("VariableCat")->listData();

        return $this->render("back/updateVariable.twig", [
            "variable"      => $variable,
            "categories"    => $categories
        ]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Variable")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Variable actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
