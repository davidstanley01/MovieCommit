<?php

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use MovieCommit\MovieCommit;

// Load Configs
$env = getenv('APP_ENV');
$defaultConfig = require "config/config.php";
$envConfig = require "config/$env.php";

$config = array_merge($defaultConfig, $envConfig);

// Start it off...
$app = new Slim($config);

// Simple DI
$app->data = function() use ($config) {
    return new MovieCommit($config['movies']);
};

// Set up views
$app->view(new Twig());
$app->view->parserOptions = $config['templates.parserOptions'];
$app->view->parserExtensions = array(new TwigExtension());

// Is it route (r-oww-te) or route (root)?
// default route
$app->get('/', function() use ($app, $env) {

    // get the line
    $line = $app->data->line;
    $app->render(
        'default.html',
        array(
            'env' => $env,
            'line' => $line
        )
    );

});

// just the facts, ma'am
$app->get('/clean', function() use ($app) {
    echo $app->data->line;
});