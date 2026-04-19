<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

/* Must be logged in */
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

/* Fetch cart items */
$cartStmt = $pdo->prepare("
    SELECT 
        c.product_id,
        c.quantity,
        p.price
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
");
$cartStmt->execute([$userId]);
$cartItems = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

/* Empty cart check */
if (empty($cartItems)) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

/* Calculate total */
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

/* PROCESS ORDER */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!in_array($_POST['order_type'], ['collection', 'delivery'])) {
        die('Invalid order type');
    }

    try {
        $pdo->beginTransaction();

        /* Insert order */
        $orderStmt = $pdo->prepare("
            INSERT INTO orders (user_id, order_total, order_status, order_type)
            VALUES (?, ?, 'pending', ?)
        ");
        $orderStmt->execute([$userId, $total, $_POST['order_type']]);

        $orderId = $pdo->lastInsertId();

        /* Insert order items */
        $itemStmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($cartItems as $item) {
            $itemStmt->execute([
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        /* Clear cart */
        $clearStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $clearStmt->execute([$userId]);

        $pdo->commit();

        header('Location: ' . BASE_URL . '/order-success.php');
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Order failed. Please try again.";
    }
}
?>

<h1>Checkout</h1>

<h3>Total: £<?= number_format($total, 2); ?></h3>

<form method="POST">
    <label>
        <input type="radio" name="order_type" value="collection" required>
        Collection
    </label>

    <label>
        <input type="radio" name="order_type" value="delivery" required>
        Delivery
    </label>

    <button type="submit" class="red-btn">Place Order</button>
</form>
