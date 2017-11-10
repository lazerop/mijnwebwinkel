<?php
//if (PHP_SAPI == 'cli-server') {
//    // To help the built-in PHP dev server, check if the request was actually for
//    // something which should probably be served as a static file
//    $url  = parse_url($_SERVER['REQUEST_URI']);
//    $file = __DIR__ . $url['path'];
//    if (is_file($file)) {
//        return false;
//    }
//}
//
//require __DIR__ . '/../vendor/autoload.php';
//
//session_start();
//
//// Instantiate the app
//$settings = require __DIR__ . '/../src/settings.php';
//$app = new \Slim\App($settings);
//
//// Set up dependencies
//require __DIR__ . '/../src/dependencies.php';
//
//// Register middleware
//require __DIR__ . '/../src/middleware.php';
//
//// Register routes
//require __DIR__ . '/../src/routes.php';
//
//// Run app
//$app->run();



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require 'classes.php';

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_DATABASE = 'webcart';

$main_db = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE", $DB_USER, $DB_PASSWORD, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
$password_salt = " hgjghfwerhjg$%%^&*";

function restResponse($response, $status, $data = null){
    $response = $response->withJson($data, $status);

    return $response;
}

$app = new \Slim\App;

header("Access-Control-Allow-Origin: *" );
header("Access-Control-Allow-Headers: origin, content-type, accept, methods");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


$app->get('/products', function (Request $request, Response $response) {
    return restResponse($response, 200, Product::getAll());
});

$app->get('/login/{user_name}/{password}', function (Request $request, Response $response, $args) {
    $user_name = $args['user_name'];
    $password = $args['password'];

    $authenticated = User::checkCredentials($user_name, $password);

    if (sizeof($authenticated) > 0) {
        User::setLoggedIn($authenticated[0]['id']);
        return restResponse($response, 200, $authenticated[0]['id']);
    }

    return restResponse($response, 401);
});

$app->get('/logout/{user_name}', function (Request $request, Response $response, $args) {
    $user_name = $args['user_name'];

    // TODO: check if the request comes from this user
    User::setLoggedOut($user_name);

    return restResponse($response, 200);
});

$app->run();