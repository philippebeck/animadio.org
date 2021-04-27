<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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
        $classes    = $this->getArrayElements($classes);

        $variables  = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $variables  = $this->getArrayElements($variables);

        $animations  = ModelFactory::getModel("Animation")->listAnimationsWithCategory();
        $animations  = $this->getArrayElements($animations);

        $breakpoints = ModelFactory::getModel("Breakpoint")->listData();

        return $this->render("front/doc.twig", [
            "classes"       => $classes,
            "variables"     => $variables,
            "animations"    => $animations,
            "breakpoints"   => $breakpoints
        ]);
    }
}
