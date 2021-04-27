<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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

        return $this->render("front/template.twig", ["templates" => $templates]);
    }

    // ******************** SETTERS ******************** \\

    private function setTemplateData()
    {
        $this->template["name"]          = (string) trim($this->getPost("name"));
        $this->template["definition"]    = (string) trim($this->getPost("definition"));

        $this->template["link"]  = (string) trim($this->getPost("link"));
        $this->template["link"]  = str_replace("https://codepen.io/animadio/pen/", "", $this->template["link"]);
    }

    private function setTemplateImage()
    {
        $this->getUploadedFile("img/templates/", $this->template["name"] . ".png");
        $this->getThumbnail("img/templates/" . $this->template["name"] . ".png", 600);
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
            $this->setTemplateData();
            $this->setTemplateImage();

            ModelFactory::getModel("Template")->createData($this->template);

            $this->setSession([
                "message"   => "New Template successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createTemplate.twig");
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
            $this->setTemplateData();

            if ($this->checkArray($this->getFiles("file"), "name")) {
                $this->setTemplateImage();
            }

            ModelFactory::getModel("Template")->updateData(
                $this->getGet("id"), 
                $this->template
            );

            $this->setSession([
                "message"   => "Successful modification of the Template !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $template = ModelFactory::getModel("Template")->readData($this->getGet("id"));

        return $this->render("back/updateTemplate.twig", ["template" => $template]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Template")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Template actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
