<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ .'/../vendor/autoload.php'); // require composer autoload
require_once(__DIR__ .'/../tools/functions.php'); // require helper functions
require_once(__DIR__ .'/../app/conf/routes.php'); // require file with routes


Dorgen()::init(); // init the application
