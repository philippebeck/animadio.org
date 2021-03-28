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

        $classes        = ModelFactory::getModel("Class")->listData();
        $variables      = ModelFactory::getModel("Variable")->listData();
        $animations     = ModelFactory::getModel("Animation")->listData();
        $breakpoints    = ModelFactory::getModel("Breakpoint")->listData();
        $elements       = ModelFactory::getModel("Element")->listData();
        $themes         = ModelFactory::getModel("Theme")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "classes"       => $classes,
            "variables"     => $variables,
            "animations"    => $animations,
            "breakpoints"   => $breakpoints,
            "elements"      => $elements,
            "themes"        => $themes,
            "users"         => $users
        ]);
    }
}
