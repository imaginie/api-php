<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie(Config::API_LOGIN, Config::API_PASSWORD);
// $Imaginie->login();
var_dump($Imaginie->getStudents());