<?php
declare(strict_types=1);

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

$env = getenv('APP_ENV') ?: $_SERVER['APP_ENV'] ?? 'dev';
$debug = ($env === 'dev');

$kernel    = new Kernel($env, $debug);
$request   = Request::createFromGlobals();
$response  = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
