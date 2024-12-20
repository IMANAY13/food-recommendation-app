<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Load konfigurasi dari file .env
$dotenv = Dotenv::createImmutable(_DIR_);
$dotenv->load();

return [
    'personalizer_key' => $_ENV['AZURE_PERSONALIZER_KEY'],
    'personalizer_endpoint' => $_ENV['AZURE_PERSONALIZER_ENDPOINT'],
];