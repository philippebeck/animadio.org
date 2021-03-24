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

        $mixins     = ModelFactory::getModel("Mixin")->listData();
        $keyframes  = ModelFactory::getModel("Keyframe")->listKeyframesWithCategory();
        $variables  = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $classes    = ModelFactory::getModel("Class")->listClassesWithCategory();
        $elements   = ModelFactory::getModel("Element")->listData();
        $themes     = ModelFactory::getModel("Theme")->listData();
        $users      = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "mixins"    => $mixins,
            "keyframes" => $keyframes,
            "variables" => $variables,
            "classes"   => $classes,
            "elements"  => $elements,
            "themes"    => $themes,
            "users"     => $users
        ]);
    }
}
