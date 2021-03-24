<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TemplateController
 * @package App\Controller
 */
class TemplateController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $templates = ModelFactory::getModel("Template")->listData();

        return $this->render("front/template.twig", [
            "templates" => $templates
        ]);
    }
}
