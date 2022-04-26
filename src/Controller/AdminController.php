<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        $classes        = ModelFactory::getModel("Class")->listClassesWithCategory();
        $variables      = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $animations     = ModelFactory::getModel("Animation")->listAnimationsWithCategory();
        $breakpoints    = ModelFactory::getModel("Breakpoint")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "classes"       => $classes,
            "variables"     => $variables,
            "animations"    => $animations,
            "breakpoints"   => $breakpoints,
            "users"         => $users
        ]);
    }
}
