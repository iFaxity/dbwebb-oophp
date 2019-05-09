<?php

use Anax\Route\Router;

/**
 * Configuration file for routes.
 */
return [
    //"mode" => Router::DEVELOPMENT, // default, verbose execeptions
    //"mode" => Router::PRODUCTION,  // exceptions turn into 500

    // Path where to mount the routes, is added to each route path.
    "mount" => null,

    // Load routes in order, start with these and the those found in
    // router/*.php.
    "routes" => [
        [
            "info" => "Dice game controller.",
            "mount" => "d100",
            "handler" => "\Faxity\Dice\DiceController",
        ],
        [
            "info" => "Movie controller.",
            "mount" => "movie",
            "handler" => "\Faxity\Movie\MovieController",
        ],
    ],
];
