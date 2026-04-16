<?php

/* prevent direct access */
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    exit('Direct access not allowed');
}

/* --------------------------------------------------------------------------
app configuration
-------------------------------------------------------------------------- */

/* Base URL (links, redirects, assets) */
define('BASE_URL', '/exam/final/');

/* File system root (absolute server path) */
define('ROOT_PATH', dirname(__DIR__));

/* --------------------------------------------------------------------------
db configuration
-------------------------------------------------------------------------- */

define('DB_HOST', 'localhost');
define('DB_NAME', 'task2_glh');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/* --------------------------------------------------------------------------
environment flags
-------------------------------------------------------------------------- */

define('APP_ENV', 'development'); // development | production

if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}