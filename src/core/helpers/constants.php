<?php

define('BASE_PATH', dirname(__DIR__, 2));
define('REQUEST_URI', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
define('VIEW_PATH', BASE_PATH . '/resources/views');
define('VIEW_PATH_CORE', BASE_PATH . '/core/resources/views');
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
