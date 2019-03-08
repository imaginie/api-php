<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';
use ApiClient\Imaginie;

echo json_encode(['data' => (string) date('d/m/Y')]); exit;
$Imaginie = new Imaginie(Config::API_LOGIN, Config::API_PASSWORD);
var_dump($Imaginie->getStudents());
