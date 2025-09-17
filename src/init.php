<?php
define("BASE_PATH", dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";
require_once BASE_PATH . "/Konfigurasyon.php";

Core\ExceptionHandler::apply();
