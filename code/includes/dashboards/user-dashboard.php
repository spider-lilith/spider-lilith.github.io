<?php
require_once __DIR__ . '/../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /TLEVEL-exam/finished/login.php');
    exit;
}
?>

<form action="/TLEVEL-exam/finished/logout.php" method="POST">
    <button type="submit" class="red-btn">Log out</button>
</form>
