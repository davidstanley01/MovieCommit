<?php

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use MovieCommit\MovieCommit;

// Load Configs
$env = (getenv('APP_ENV') ?: 'prod');
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

// just the facts, ma'am
$app->get('/clean', function() use ($app) {

    $quote = $app->data->getQuote();
    echo $quote['line'] .' - '. $quote['title'];

});

// just the facts, ma'am, with a permalink
$app->get('/clean/(:id)', function($id = null) use ($app) {

    $quote = $app->data->getQuoteById($id);
    echo $quote['line'] .' - '. $quote['title'];

});

// Is it route (r-oww-te) or route (root)?
// default route
$app->get('/(:id)', function($id = null) use ($app, $env) {

    if (is_null($id)) {
        $quote = $app->data->getQuote();
    } else {
        $quote = $app->data->getQuoteById($id);
    }

    $app->render(
        'default.html',
        array(
            'env'   => $env,
            'line'  => $quote['line'],
            'title' => $quote['title'],
            'permalink' => $quote['permalink']
        )
    );

});
