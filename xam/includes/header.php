<?php
require_once __DIR__ . '/session.php';

/* default profile link */
$profileLink = BASE_URL . 'login.php';

if (!empty($_SESSION['user_id'])) {
    $profileLink = BASE_URL . 'dashboard.php';
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>includes/css/styles.css">

    <!-- External resources -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Rock+Salt&display=swap" rel="stylesheet">

    <title>Greenfield Local Hub</title>
</head>
<body>

<!-- ---------------------------------------------------------------------------------------------- -->

<div class="header-box">

    <div class="header-img">
        <img src="<?= BASE_URL ?>img/GLH-logo.png" alt="Logo">
    </div>

    <div class="header-links">
        <a href="<?= BASE_URL ?>index.php">Home</a>
        <a href="<?= BASE_URL ?>products.php">Products</a>
        <a href="<?= BASE_URL ?>about.php">About</a>
        <a href="<?= BASE_URL ?>producers.php">Farmers</a>
    </div>

    <div class="header-buttons">
        <a href="<?= htmlspecialchars($profileLink, ENT_QUOTES, 'UTF-8'); ?>"
            aria-label="<?= isset($_SESSION['user_id']) ? 'My account' : 'Login'; ?>">
            <i class="fa-solid fa-circle-user"></i>
        </a>

        <a href="<?= BASE_URL ?>cart.php" aria-label="Cart">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </div>

</div>