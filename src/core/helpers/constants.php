<?php

define('BASE_PATH', dirname(__DIR__, 2));
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('VIEW_PATH', BASE_PATH . '/resources/views');
define('VIEW_PATH_CORE', BASE_PATH . '/core/resources/views');
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
