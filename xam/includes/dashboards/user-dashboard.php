<?php
require_once __DIR__ . '/../session.php';

// must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// role check 
if ($_SESSION['user_role'] !== 'customer') {
    exit('Access denied');
}

require_once ROOT_PATH . '/includes/header.php';
?>

<img src="<?= BASE_URL ?>img/apple-background.png" alt="Dashboard background">

<div class="dashboard-container">

    <div class="dash-header">
        <h1>Good to see you, <?= htmlspecialchars($_SESSION['name'] ?? ''); ?></h1>

        <form action="<?= BASE_URL ?>logout.php" method="post">
            <button type="submit" class="red-btn">Log out</button>
        </form>
    </div>

    <div class="details">
        <div class="acc-details">
            <h3>Account Details</h3>
            <p>First Name: <?= htmlspecialchars($_SESSION['first_name'] ?? ''); ?></p>
            <p>Surname: <?= htmlspecialchars($_SESSION['last_name'] ?? ''); ?></p>

            <button class="black-btn">Edit</button>
        </div>

        <div class="pay-details">
            <h3>Payment Details</h3>
            <p>Name on Card: —</p>
            <p>Card Number: —</p>

            <button class="black-btn">Edit</button>
        </div>
    </div>

    <div class="loyalty-section">
        <div class="loyalty-btn">
            <button class="red-btn">Join Loyalty Scheme</button>
        </div>
        <div class="loyalty-abt">
            <h5>Benefits of Becoming a Member</h5>
            <p>Lorem ipsum dolor sit amet el</p>
        </div>
    </div>

    <div class="current-order">
        <p>You don't have any orders!</p>
    </div>

    <hr>

    <div class="previous-orders">
        <div class="order">
            <h3>Collection</h3>
            <ul>
                <li>Item 1</li>
                <li>Item 2</li>
            </ul>
        </div>

        <div class="order">
            <h3>Delivery</h3>
            <ul>
                <li>Item 1</li>
                <li>Item 2</li>
            </ul>
        </div>
    </div>

</div>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>