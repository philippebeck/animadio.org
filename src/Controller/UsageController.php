<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UsageController
 * @package App\Controller
 */
class UsageController extends MainController
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
        $variables = $this->getArrayElements($variables);

        return $this->render("front/usage.twig", ["variables" => $variables]);
    }
}
