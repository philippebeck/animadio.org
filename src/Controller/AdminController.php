<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        $keyframes  = ModelFactory::getModel("Keyframes")->listData();
        $grid       = ModelFactory::getModel("Grid")->listData();
        $elements   = ModelFactory::getModel("Elements")->listData();
        $states     = ModelFactory::getModel("States")->listData();
        $helpers    = ModelFactory::getModel("Helpers")->listData();
        $users      = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "keyframes" => $keyframes,
            "grid"      => $grid,
            "elements"  => $elements,
            "states"    => $states,
            "helpers"   => $helpers,
            "users"     => $users
        ]);
    }
}
