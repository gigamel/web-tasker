<?php
require_once '../autoload.php';

\Application::createInstance()
    ->setDefaultController('task')
    ->setRouteVar('route')
    ->loadSettings('db')
    ->run();