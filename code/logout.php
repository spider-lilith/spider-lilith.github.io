<?php
session_start();

$_SESSION = [];            // clear all session data
session_destroy();         // destroy session
session_unset();           // safety

header('Location: /TLEVEL-exam/finished/login.php');
exit;