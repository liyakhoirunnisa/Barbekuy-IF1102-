<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Jika aplikasi sedang maintenance, load file maintenance
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader Composer
require __DIR__.'/../vendor/autoload.php';

// Bootstrap aplikasi
$app = require_once __DIR__.'/../bootstrap/app.php';

// Ambil kernel HTTP
/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Tangkap request
$request = Request::capture();

// Handle request jadi response
$response = $kernel->handle($request);

// Kirim response ke browser
$response->send();

// Terminate kernel (untuk middleware/clean up)
$kernel->terminate($request, $response);
