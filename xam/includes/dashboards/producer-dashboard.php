<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../db.php';

if ($_SESSION['user_role'] !== 'producer') {
    exit('Access denied');
}

require_once ROOT_PATH . '/includes/header.php';
?>

<form action="<?= BASE_URL ?>logout.php" method="post">
    <button type="submit" class="red-btn">Log out</button>
</form>