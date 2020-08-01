<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HelpersController
 * @package App\Controller
 */
class HelpersController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $helpersClassesList = ModelFactory::getModel("Helpers")->listHelpersClasses();
        $helpersClasses     = $this->getArray()->getArrayElements($helpersClassesList, "class");

        return $this->render("front/helpers/helpers.twig", [
            "fontClasses"   => $helpersClasses["font"],
            "transClasses"  => $helpersClasses["trans"],
            "alignClasses"  => $helpersClasses["align"],
            "decoClasses"   => $helpersClasses["deco"],
            "shatexClasses" => $helpersClasses["shatex"],
            "shaboxClasses" => $helpersClasses["shabox"],
            "cursorClasses" => $helpersClasses["cursor"]
        ]);
    }
}
