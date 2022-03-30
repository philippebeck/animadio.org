<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ElementController
 * @package App\Controller
 */
class ElementController extends MainController
{
    /**
     * @var array
     */
    private $element = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $elements = ModelFactory::getModel("Element")->listData();

        return $this->render("front/element.twig", ["elements" => $elements]);
    }

    // ******************** SETTERS ******************** \\

    private function setElementData()
    {
        $this->element["name"]          = (string) trim($this->getPost("name"));
        $this->element["definition"]    = (string) trim($this->getPost("definition"));

        $this->element["link"]  = (string) trim($this->getPost("link"));
        $this->element["link"]  = str_replace("https://codepen.io/philippebeck/pen/", "", $this->element["link"]);
    }

    private function setElementImage()
    {
        $this->getUploadedFile("img/elements/", $this->element["name"] . ".png");
        $this->getThumbnail("img/elements/" . $this->element["name"] . ".png", 600);
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
            $this->setElementData();
            $this->setElementImage();

            ModelFactory::getModel("Element")->createData($this->element);

            $this->setSession([
                "message"   => "New Element successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createElement.twig");
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
            $this->setElementData();

            if ($this->checkArray($this->getFiles("file"), "name")) {
                $this->setElementImage();
            }

            ModelFactory::getModel("Element")->updateData(
                $this->getGet("id"), 
                $this->element
            );

            $this->setSession([
                "message"   => "Successful modification of the Element !",
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $element = ModelFactory::getModel("Element")->readData($this->getGet("id"));

        return $this->render("back/updateElement.twig", ["element" => $element]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Element")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Element actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
