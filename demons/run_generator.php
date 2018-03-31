<?php
require_once(__DIR__ .'/../vendor/autoload.php'); // require composer autoload
require_once(__DIR__ .'/../tools/functions.php'); // require helper functions

$GLOBALS['tries'] = 0;

$demon2 = new \Demons\GeneratorDemon();
$demon2->run();