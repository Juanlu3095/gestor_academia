<?php

namespace config;

require_once 'env.php';

return [
    'DB_HOST' => $_ENV['DB_HOST'],
    'DB_USER' => $_ENV['DB_USERNAME'],
    'DB_PASS' => $_ENV['DB_PASSWORD'],
    'DB_NAME' => $_ENV['DB_DATABASE']
]
?>