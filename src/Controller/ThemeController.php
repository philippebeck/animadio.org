<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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

        return $this->render("front/theme.twig", [
            "themes" => $themes
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
            $this->setThemeData();
            $this->setThemeImage();

            ModelFactory::getModel("Theme")->createData($this->theme);
            $this->getSession()->createAlert("New theme successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/theme/createTheme.twig");
    }

    private function setThemeData()
    {
        $this->theme["name"]          = (string) trim($this->getPost()->getPostVar("name"));
        $this->theme["definition"]    = (string) trim($this->getPost()->getPostVar("definition"));

        $this->theme["link"]  = (string) trim($this->getPost()->getPostVar("link"));
        $this->theme["link"]  = str_replace("https://codepen.io/animadio/pen/", "", $this->theme["link"]);
    }

    private function setThemeImage()
    {
        $this->getFiles()->uploadFile("img/themes/", $this->theme["name"] . ".png");
        $this->getImage()->makeThumbnail("img/themes/" . $this->theme["name"] . ".png", 600);
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
            $this->setThemeData();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setThemeImage();
            }

            ModelFactory::getModel("Theme")->updateData($this->getGet()->getGetVar("id"), $this->theme);
            $this->getSession()->createAlert("Successful modification of the theme !", "blue");

            $this->redirect("admin");
        }

        $theme = ModelFactory::getModel("Theme")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/theme/updateTheme.twig", [
            "theme" => $theme
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Theme")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Theme actually deleted !", "red");

        $this->redirect("admin");
    }
}
