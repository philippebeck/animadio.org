<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class GlobalController
 * @package App\Controller
 */
class GlobalController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $keyframes = ModelFactory::getModel("Keyframes")->listData();

        return $this->render("front/global/global.twig", ["keyframes" => $keyframes]);
    }
}
