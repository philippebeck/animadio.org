<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AnimationController
 * @package App\Controller
 */
class AnimationController extends MainController
{
    /**
     * @var array
     */
    private $animation = [];

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
            $this->setAnimationData();

            ModelFactory::getModel("Animation")->createData($this->animation);
            $this->getSession()->createAlert("New animation successfully created !", "green");

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("AnimationCat")->listData();

        return $this->render("back/animation/createAnimation.twig", [
            "categories" => $categories
        ]);
    }

    private function setAnimationData()
    {
        $this->animation["name"]         = (string) trim($this->getPost()->getPostVar("name"));
        $this->animation["effect"]       = (string) trim($this->getPost()->getPostVar("effect"));
        $this->animation["category_id"]  = (int) $this->getPost()->getPostVar("category_id");
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
            $this->setAnimationData();

            ModelFactory::getModel("Animation")->updateData($this->getGet()->getGetVar("id"), $this->animation);
            $this->getSession()->createAlert("Successful modification of the animation !", "blue");

            $this->redirect("admin");
        }

        $animation   = ModelFactory::getModel("Animation")->readData($this->getGet()->getGetVar("id"));
        $categories = ModelFactory::getModel("AnimationCat")->listData();

        return $this->render("back/animation/updateAnimation.twig", [
            "animation"     => $animation,
            "categories"    => $categories
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Animation")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Animation actually deleted !", "red");

        $this->redirect("admin");
    }
}
