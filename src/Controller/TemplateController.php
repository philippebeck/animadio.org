<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TemplateController
 * @package App\Controller
 */
class TemplateController extends MainController
{
    /**
     * @var array
     */
    private $template = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $templates = ModelFactory::getModel("Template")->listData();

        return $this->render("front/items/template.twig", [
            "templates" => $templates
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
            $this->setTemplateData();
            $this->setTemplateImage();

            ModelFactory::getModel("Template")->createData($this->template);
            $this->getSession()->createAlert("New template successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/template/createTemplate.twig");
    }

    private function setTemplateData()
    {
        $this->template["name"]          = (string) trim($this->getPost()->getPostVar("name"));
        $this->template["definition"]    = (string) trim($this->getPost()->getPostVar("definition"));

        $this->template["link"]  = (string) trim($this->getPost()->getPostVar("link"));
        $this->template["link"]  = str_replace("https://codepen.io/animadio/pen/", "", $this->template["link"]);
    }

    private function setTemplateImage()
    {
        $this->getFiles()->uploadFile("img/templates/", $this->template["name"] . ".png");
        $this->getImage()->makeThumbnail("img/templates/" . $this->template["name"] . ".png", 600);
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
            $this->setTemplateData();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setTemplateImage();
            }

            ModelFactory::getModel("Template")->updateData($this->getGet()->getGetVar("id"), $this->template);
            $this->getSession()->createAlert("Successful modification of the template !", "blue");

            $this->redirect("admin");
        }

        $template = ModelFactory::getModel("Template")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/template/updateTemplate.twig", [
            "template" => $template
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Template")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Template actually deleted !", "red");

        $this->redirect("admin");
    }
}
