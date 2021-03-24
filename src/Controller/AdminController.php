<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        $classes        = ModelFactory::getModel("Class")->listClassesWithCategory();
        $variables      = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $keyframes      = ModelFactory::getModel("Keyframe")->listKeyframesWithCategory();
        $breakpoints    = ModelFactory::getModel("Breakpoint")->listData();
        $mixins         = ModelFactory::getModel("Mixin")->listData();
        $elements       = ModelFactory::getModel("Element")->listData();
        $themes         = ModelFactory::getModel("Theme")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "classes"       => $classes,
            "variables"     => $variables,
            "keyframes"     => $keyframes,
            "breakpoints"   => $breakpoints,
            "mixins"        => $mixins,
            "elements"      => $elements,
            "themes"        => $themes,
            "users"         => $users
        ]);
    }
}
