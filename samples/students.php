<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie(Config::API_LOGIN, Config::API_PASSWORD);
var_dump($Imaginie->getStudents());
var_dump($Imaginie->getResponseHeaders());
