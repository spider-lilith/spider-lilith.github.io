<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/TLEVEL-exam/finished');

$profileLink = BASE_URL . '/login.php';

if (!empty($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'producer') {
        $profileLink = BASE_URL . '/includes/dashboards/producer-dashboard.php';
    } else {
        $profileLink = BASE_URL . '/includes/dashboards/user-dashboard.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Rock+Salt&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
    <div class="header-box">

        <div class="header-img">
            <img src='img/GLH-logo.png'>
        </div>
        
        <div class="header-links">
            <a href="<?= BASE_URL ?>/index.php">Home</a>
            <a href="<?= BASE_URL ?>/products.php">Products</a>
            <a href="#">About</a>
            <a href="#">Farmers</a>
        </div>

        <div class="header-buttons">
            <a href="<?= htmlspecialchars($profileLink, ENT_QUOTES, 'UTF-8'); ?>"
            aria-label="<?= isset($_SESSION['user_id']) ? 'My account' : 'Login'; ?>">
                <i class="fa-solid fa-circle-user"></i>
            </a>
            <a href="<?= BASE_URL ?>/cart.php" aria-label="Cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    
    </div>

</body>
</html>