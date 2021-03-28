<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class DocController
 * @package App\Controller
 */
class DocController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $classes    = ModelFactory::getModel("Class")->listClassesWithCategory();
        $classes    = $this->getArray()->getArrayElements($classes);

        $variables  = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $variables  = $this->getArray()->getArrayElements($variables);

        $animations  = ModelFactory::getModel("Animation")->listAnimationsWithCategory();
        $animations  = $this->getArray()->getArrayElements($animations);

        $breakpoints = ModelFactory::getModel("Breakpoint")->listData();

        return $this->render("front/doc.twig", [
            "classes"       => $classes,
            "variables"     => $variables,
            "animations"    => $animations,
            "breakpoints"   => $breakpoints
        ]);
    }
}
