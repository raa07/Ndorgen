<?php
use Tools\Router;

Router::add('/', 'MainController', 'index');
Router::add('/post', 'MainController', 'post');