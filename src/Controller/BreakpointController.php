<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class BreakpointController
 * @package App\Controller
 */
class BreakpointController extends MainController
{
    /**
     * @var array
     */
    private $breakpoint = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $this->redirect("doc");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setBreakpointData();

            ModelFactory::getModel("Breakpoint")->createData($this->breakpoint);
            $this->getSession()->createAlert("New breakpoint successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/breakpoint/createBreakpoint.twig");
    }

    private function setBreakpointData()
    {
        $this->breakpoint["media"]  = (string) trim($this->getPost()->getPostVar("media"));
        $this->breakpoint["width"]  = (string) trim($this->getPost()->getPostVar("width"));
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setBreakpointData();

            ModelFactory::getModel("Breakpoint")->updateData($this->getGet()->getGetVar("id"), $this->breakpoint);
            $this->getSession()->createAlert("Successful modification of the breakpoint !", "blue");

            $this->redirect("admin");
        }

        $breakpoint = ModelFactory::getModel("Breakpoint")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/breakpoint/updateBreakpoint.twig", [
            "breakpoint" => $breakpoint
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Breakpoint")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Breakpoint actually deleted !", "red");

        $this->redirect("admin");
    }
}
