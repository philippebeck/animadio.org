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
        $variables = ModelFactory::getModel("Variable")->listVariablesWithCategory();
        $variables = $this->getArray()->getArrayElements($variables);

        return $this->render("front/doc.twig", [
            "variables" => $variables
        ]);
    }
}
