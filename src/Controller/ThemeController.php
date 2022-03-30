<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ThemeController
 * @package App\Controller
 */
class ThemeController extends MainController
{
    /**
     * @var array
     */
    private $theme = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $themes = ModelFactory::getModel("Theme")->listData();

        return $this->render("front/theme.twig", ["themes" => $themes]);
    }

    // ******************** SETTERS ******************** \\

    private function setThemeData()
    {
        $this->theme["name"]          = (string) trim($this->getPost("name"));
        $this->theme["definition"]    = (string) trim($this->getPost("definition"));

        $this->theme["link"]  = (string) trim($this->getPost("link"));
        $this->theme["link"]  = str_replace("https://codepen.io/philippebeck/pen/", "", $this->theme["link"]);
    }

    private function setThemeImage()
    {
        $this->getUploadedFile("img/themes/", $this->theme["name"] . ".png");
        $this->getThumbnail("img/themes/" . $this->theme["name"] . ".png", 600);
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
            $this->setThemeData();
            $this->setThemeImage();

            ModelFactory::getModel("Theme")->createData($this->theme);

            $this->setSession([
                "message"   => "New Theme successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createTheme.twig");
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
            $this->setThemeData();

            if ($this->checkArray($this->getFiles("file"), "name")) {
                $this->setThemeImage();
            }

            ModelFactory::getModel("Theme")->updateData(
                $this->getGet("id"), 
                $this->theme
            );

            $this->setSession([
                "message"   => "Successful modification of the Theme !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $theme = ModelFactory::getModel("Theme")->readData($this->getGet("id"));

        return $this->render("back/updateTheme.twig", ["theme" => $theme]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Theme")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Theme actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
