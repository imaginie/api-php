<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ApiClient\Imaginie;

$Imaginie = new Imaginie('escola@email.com.br', '123456');
$Imaginie->login();
var_dump($Imaginie->getStudents());