<?php

use Pam\Controller\FrontController;
use Tracy\Debugger;

require_once '../vendor/autoload.php';
require_once '../config/dev-params.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Debugger::enable();

$frontController = new FrontController();
$frontController->run();
