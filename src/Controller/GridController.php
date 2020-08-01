<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class GridController
 * @package App\Controller
 */
class GridController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $gridClassesList    = ModelFactory::getModel("Grid")->listGridClasses();
        $gridClasses        = $this->getArray()->getArrayElements($gridClassesList, "class");

        return $this->render("front/grid/grid.twig", [
            "gridClasses"   => $gridClasses["grid"],
            "flexClasses"   => $gridClasses["flex"],
            "placeClasses"  => $gridClasses["place"]
        ]);
    }
}
