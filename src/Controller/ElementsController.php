<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ElementsController
 * @package App\Controller
 */
class ElementsController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $elementsClassList  = ModelFactory::getModel("Elements")->listData();
        $elementsClasses    = $this->getArray()->getArrayElements($elementsClassList, "class");

        return $this->render("front/elements/elements.twig", [
            "btnClasses"   => $elementsClasses["btn"],
            "cardClasses"  => $elementsClasses["card"]
        ]);
    }
}
