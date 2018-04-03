<?php

require_once(__DIR__ .'/../vendor/autoload.php'); // require composer autoload
require_once(__DIR__ .'/../tools/functions.php'); // require helper functions

App\Config::init(__DIR__ .'/../app/conf/general.php');
$demon1 = new Demons\ScheduleDemon();
$demon1->run();