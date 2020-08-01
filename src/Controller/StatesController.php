<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class StatesController
 * @package App\Controller
 */
class StatesController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $statesClassesList  = ModelFactory::getModel("States")->listStatesClasses();
        $statesClasses      = $this->getArray()->getArrayElements($statesClassesList, "class");

        return $this->render("front/states/states.twig", [
            "animaClasses"      => $statesClasses["anima"],
            "displayClasses"    => $statesClasses["display"],
            "positionClasses"   => $statesClasses["position"],
            "bgClasses"         => $statesClasses["bg"],
            "colorClasses"      => $statesClasses["color"]
        ]);
    }
}
