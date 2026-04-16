<?php
require_once __DIR__ . '/includes/session.php';

$_SESSION = [];
session_unset();
session_destroy();

header('Location: ' . BASE_URL . 'login.php');
exit;

?>