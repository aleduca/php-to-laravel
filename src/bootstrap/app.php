<?php

require '../core/helpers/constants.php';
require '../core/helpers/functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();
