<?php

namespace config;

use Dotenv\Dotenv;

// Permite acceder a las variables de entorno desde un único archivo
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

?>