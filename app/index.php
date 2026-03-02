<?php

include_once "./vendor/autoload.php";

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
$capsule->addConnection([
    'driver' => "pgsql",
    "host" => "postgres",
    "database" => trim(getenv("SISU_DB_NAME")),
    "username" => trim(getenv("SISU_DB_USER")),
    "password" => trim(getenv("SISU_DB_PASS"))
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

function app(): void
{
    $requestPath = strtok($_SERVER['REQUEST_URI'], '?');
    $segments = explode('/', $requestPath);

    if (empty($segments[1])) {
        $__viewFile = getcwd() . '/views/home/index.php';
        include $__viewFile;
        return;
    }

    $controllerName = '\\App\\Controllers\\' . ucfirst($segments[1]) . 'Controller';
    $controller = new $controllerName();

    parse_str($_SERVER['QUERY_STRING'], $queryParams);

    $action = $segments[2] ?? 'index';
    $actionParams = array_values($queryParams);

    $controller->{$action}(...$actionParams);
}

app();
