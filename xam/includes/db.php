<?php

/* load config file that contains database constants
(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET, APP_ENV, etc.) */
require_once __DIR__ . '/config.php';

/* build data source name for PDO connection */
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

/* define pdo options to help with error handling & fetching */
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    /* attempt to create new pdo db conn */
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {

    /* if app is runnning in dev mode, show full error message for debugging help */
    if (defined('APP_ENV') && APP_ENV === 'development') {
        die('Database connection failed: ' . $e->getMessage());
    }
    /* generic db fail message avoid exposing anymore details on public pages */
    die('Database connection failed.');
}

?>