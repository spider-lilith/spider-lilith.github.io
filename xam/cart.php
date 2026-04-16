<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

/* protect cart - user must be logged in to use cart */
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

/* storing user id */
$userId = $_SESSION['user_id'];

/* fetch users cart items, joining it with products table to display details */
$stmt = $pdo->prepare("
    SELECT 
        c.cart_id,
        p.product_name,
        p.price,
        c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
");

/* execute query, including the user's ID */
$stmt->execute([$userId]);
/* fetch all cart items as associative array */
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ---------------------------------------------------------------------------------------------- 
Page Content
---------------------------------------------------------------------------------------------- -->

<h1>Your Cart</h1>

<?php if (empty($items)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>

<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th>Remove</th>
    </tr>

    <?php
    /* initialise total cost */
    $total = 0;

    /* loop through each cart item, calculate & add subtotal to total cost */
    foreach ($items as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
        <tr>
            <td><?= htmlspecialchars($item['product_name']); ?></td>
            <td>£<?= number_format($item['price'], 2); ?></td>
            <td><?= $item['quantity']; ?></td>
            <td>£<?= number_format($subtotal, 2); ?></td>
            <td><a href="cart-remove.php?id=<?= $item['cart_id']; ?>">Remove</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- total price display -->
<h3>Total: £<?= number_format($total, 2); ?></h3>

<!-- link to checkout -->
<a href="checkout.php" class="red-btn">Proceed to Checkout</a>

<?php endif; ?>