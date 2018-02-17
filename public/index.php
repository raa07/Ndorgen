<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ .'/../tools/Router.php');
require_once(__DIR__ .'/../app/conf/routes.php');
require_once(__DIR__ .'/../app/View.php');
require_once(__DIR__ .'/../app/Dorgen.php');
require_once(__DIR__ .'/../tools/functions.php');

require_once(__DIR__ .'/../vendor/autoload.php');


Dorgen()::init();

var_dump($_SERVER['SERVER_NAME']);
