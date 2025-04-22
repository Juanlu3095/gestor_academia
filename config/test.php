<?php

namespace config;

require_once 'testenv.php';

$dbconfig = [
    'DB_HOST' => $_ENV['DB_HOST'],
    'DB_USER' => $_ENV['DB_USERNAME'],
    'DB_PASS' => $_ENV['DB_PASSWORD'],
    'DB_NAME' => $_ENV['DB_DATABASE']
];

$urltest = $_ENV['URL_BASE_TESTS'];

define('DBCONFIG_TEST', $dbconfig);
define('URL_TEST', $urltest);
?>