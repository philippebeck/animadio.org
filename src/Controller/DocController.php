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
        $mixins = ModelFactory::getModel("Mixin")->listData();

        $keyframes  = ModelFactory::getModel("Keyframe")->listKeyframesWithCategory();
        $keyframes  = $this->getArray()->getArrayElements($keyframes);

        $variables  = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $variables  = $this->getArray()->getArrayElements($variables);

        $classes    = ModelFactory::getModel("Class")->listClassesWithCategory();
        $classes    = $this->getArray()->getArrayElements($classes);

        return $this->render("front/doc.twig", [
            "mixins"    => $mixins,
            "keyframes" => $keyframes,
            "variables" => $variables,
            "classes"   => $classes
        ]);
    }
}
