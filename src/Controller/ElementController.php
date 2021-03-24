<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ElementController
 * @package App\Controller
 */
class ElementController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $elements = ModelFactory::getModel("Element")->listData();

        return $this->render("front/element.twig", [
            "elements" => $elements
        ]);
    }
}
