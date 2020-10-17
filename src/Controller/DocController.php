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
        /*$keyframes          = ModelFactory::getModel("Keyframes")->listData();
        $gridClasses        = $this->getArray()->getArrayElements(ModelFactory::getModel("Grid")->listGridClasses(), "class");
        $elementsClasses    = $this->getArray()->getArrayElements(ModelFactory::getModel("Elements")->listData(), "class");
        $statesClasses      = $this->getArray()->getArrayElements(ModelFactory::getModel("States")->listStatesClasses(), "class");
        $helpersClasses     = $this->getArray()->getArrayElements(ModelFactory::getModel("Helpers")->listHelpersClasses(), "class");*/

        return $this->render("front/doc.twig"/*, [
            "keyframes"         => $keyframes,
            "gridClasses"       => $gridClasses["grid"],
            "flexClasses"       => $gridClasses["flex"],
            "placeClasses"      => $gridClasses["place"],
            "btnClasses"        => $elementsClasses["btn"],
            "cardClasses"       => $elementsClasses["card"],
            "animaClasses"      => $statesClasses["anima"],
            "displayClasses"    => $statesClasses["display"],
            "positionClasses"   => $statesClasses["position"],
            "bgClasses"         => $statesClasses["bg"],
            "colorClasses"      => $statesClasses["color"],
            "fontClasses"       => $helpersClasses["font"],
            "transClasses"      => $helpersClasses["trans"],
            "alignClasses"      => $helpersClasses["align"],
            "decoClasses"       => $helpersClasses["deco"],
            "shatexClasses"     => $helpersClasses["shatex"],
            "shaboxClasses"     => $helpersClasses["shabox"],
            "cursorClasses"     => $helpersClasses["cursor"]
        ]*/);
    }
}
