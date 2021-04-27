<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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

    private function setBreakpointData()
    {
        $this->breakpoint["media"]  = (string) trim($this->getPost("media"));
        $this->breakpoint["width"]  = (string) trim($this->getPost("width"));
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {
            $this->setBreakpointData();

            ModelFactory::getModel("Breakpoint")->createData($this->breakpoint);
            
            $this->setSession([
                "message"   => "New breakpoint successfully created !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createBreakpoint.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {
            $this->setBreakpointData();

            ModelFactory::getModel("Breakpoint")->updateData(
                $this->getGet("id"), 
                $this->breakpoint
            );

            $this->setSession([
                "message"   => "Successful modification of the breakpoint !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        $breakpoint = ModelFactory::getModel("Breakpoint")->readData($this->getGet("id"));

        return $this->render("back/updateBreakpoint.twig", ["breakpoint" => $breakpoint]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Breakpoint")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Breakpoint actually deleted !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
