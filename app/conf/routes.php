<?php
use Tools\Router;

Router::add('/', 'MainController', 'index');
Router::add('/post', 'PostsController', 'post');

Router::add('/install', 'InstallController', 'firstStepView');
Router::add('/install/second-step', 'InstallController', 'firstStep');
Router::add('/install/third-step', 'InstallController', 'secondStep');
Router::add('/install/third-step-form', 'InstallController', 'thirdStep');
Router::add('/install/done', 'InstallController', 'done');

Router::add('/install/create-category', 'InstallController', 'createCategory');
