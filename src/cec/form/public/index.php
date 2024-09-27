<?php

require_once __DIR__.'/../src/constants/constants.php';
require_once __DIR__.'/../src/controllers/HomeController.php';
require_once __DIR__.'/../src/utils/Print.php';
$controller = new HomeController();
$controller->handleRequest();
