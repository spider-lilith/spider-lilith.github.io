<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../db.php';

if ($_SESSION['user_role'] !== 'producer') {
    exit('Access denied');
}

require_once ROOT_PATH . '/includes/header.php';

/* Access control */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'producer') {
    header('Location: /TLEVEL-exam/finished/login.php');
    exit;
}

/* Get producer_id for logged-in user */
$producerStmt = $pdo->prepare("
    SELECT producer_id
    FROM producers
    WHERE user_id = ?
");
$producerStmt->execute([$_SESSION['user_id']]);
$producerId = $producerStmt->fetchColumn();

if (!$producerId) {
    echo "<p>No producer account found.</p>";
    exit;
}

/* Handle stock update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['quantity'])) {

        $updateStmt = $pdo->prepare("
            UPDATE products
            SET quantity = ?
            WHERE product_id = ?
            AND producer_id = ?
        ");

        $updateStmt->execute([
            (int)$_POST['quantity'],
            (int)$_POST['product_id'],
            $producerId
        ]);
    }
}

/* Fetch producer products */
$productStmt = $pdo->prepare("
    SELECT product_id, product_name, quantity
    FROM products
    WHERE producer_id = ?
");
$productStmt->execute([$producerId]);
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Producer Dashboard</h1>

<form action="/TLEVEL-exam/finished/logout.php" method="POST" class="logout-form">
    <button type="submit" class="red-btn">Log out</button>
</form>

<h2>Your Products</h2>

<?php if (empty($products)): ?>
    <p>You currently have no products listed.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Product</th>
            <th>Current Stock</th>
            <th>Update Stock</th>
        </tr>

        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['product_name']); ?></td>
                <td><?= (int)$product['quantity']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                        <input
                            type="number"
                            name="quantity"
                            min="0"
                            value="<?= (int)$product['quantity']; ?>"
                            required
                        >
                        <button type="submit" class="red-btn">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
