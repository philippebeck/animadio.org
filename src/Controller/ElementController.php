<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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

        return $this->render("front/items/element.twig", [
            "elements" => $elements
        ]);
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
            $this->setElementData();
            $this->setElementImage();

            ModelFactory::getModel("Element")->createData($this->element);
            $this->getSession()->createAlert("New element successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/element/createElement.twig");
    }

    private function setElementData()
    {
        $this->element["name"]          = (string) trim($this->getPost()->getPostVar("name"));
        $this->element["definition"]    = (string) trim($this->getPost()->getPostVar("definition"));

        $this->element["link"]  = (string) trim($this->getPost()->getPostVar("link"));
        $this->element["link"]  = str_replace("https://codepen.io/animadio/pen/", "", $this->element["link"]);
    }

    private function setElementImage()
    {
        $this->getFiles()->uploadFile("img/elements/", $this->element["name"] . ".png");
        $this->getImage()->makeThumbnail("img/elements/" . $this->element["name"] . ".png", 600);
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
            $this->setElementData();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setElementImage();
            }

            ModelFactory::getModel("Element")->updateData($this->getGet()->getGetVar("id"), $this->element);
            $this->getSession()->createAlert("Successful modification of the element !", "blue");

            $this->redirect("admin");
        }

        $element = ModelFactory::getModel("Element")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/element/updateElement.twig", [
            "element" => $element
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Element")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Element actually deleted !", "red");

        $this->redirect("admin");
    }
}
