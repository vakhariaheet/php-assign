<?php

require_once __DIR__.'/../src/controllers/RegisterController.php';

$registerController = new RegisterController();

$registerController->handleRequest();
