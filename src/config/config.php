<?php

return array(

    // Views options and configs
    'templates.path' => __DIR__. '/../templates',
    'templates.parserOptions' => array(
        'charset' => 'utf-8',
        'cache' => __DIR__. '/../templates/cache',
        'auto_reload' => true,
        'strict_variables' => false,
        'autoescape' => true
    ),

    // Movies and lines
    'movies' => array(
        'HolyGrail',
        'Cars',
        'PulpFiction',
        'GodFather',
        'RockyBalboa'
    ),

);
