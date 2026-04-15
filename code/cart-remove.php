<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: cart.php');
    exit;
}

$stmt = $pdo->prepare("
    DELETE FROM cart
    WHERE cart_id = ? AND user_id = ?
");
$stmt->execute([
    (int)$_GET['id'],
    $_SESSION['user_id']
]);

header('Location: cart.php');
exit;
