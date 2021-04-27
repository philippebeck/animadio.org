<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {
            $this->setAnimationData();

            ModelFactory::getModel("Animation")->createData($this->animation);

            $this->setSession([
                "message"   => "New animation successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        $categories = ModelFactory::getModel("AnimationCat")->listData();

        return $this->render("back/createAnimation.twig", ["categories" => $categories]);
    }

    private function setAnimationData()
    {
        $this->animation["name"]         = (string) trim($this->getPost("name"));
        $this->animation["effect"]       = (string) trim($this->getPost("effect"));
        $this->animation["category_id"]  = (int) $this->getPost("category_id");
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
            $this->setAnimationData();

            ModelFactory::getModel("Animation")->updateData(
                $this->getGet("id"), 
                $this->animation
            );

            $this->setSession([
                "message"   => "Successful modification of the animation !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $animation  = ModelFactory::getModel("Animation")->readData($this->getGet("id"));
        $categories = ModelFactory::getModel("AnimationCat")->listData();

        return $this->render("back/updateAnimation.twig", [
            "animation"     => $animation,
            "categories"    => $categories
        ]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Animation")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Animation actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
