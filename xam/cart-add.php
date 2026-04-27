<!-- code for adding items to cart functionality -->

<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';


/* user must be logged in */
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

/* validate input */
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    header('Location: products.php');
    exit;
}

$productId = (int)$_POST['product_id'];
$userId = $_SESSION['user_id'];

/* check stock level */
$stockStmt = $pdo->prepare("
    SELECT quantity
    FROM products
    WHERE product_id = ?
");
$stockStmt->execute([$productId]);
$stock = $stockStmt->fetchColumn();

if ($stock === false || $stock <= 0) {
    header('Location: ' . BASE_URL . '/products.php?error=out_of_stock');
    exit;
}

/* check if product is already in cart */
$stmt = $pdo->prepare("
    SELECT quantity 
    FROM cart 
    WHERE user_id = :user AND product_id = :product
");
$stmt->execute([
    'user' => $userId,
    'product' => $productId
]);

$existing = $stmt->fetch();

if ($existing) {
    /* increment quantity */
    $update = $pdo->prepare("
        UPDATE cart 
        SET quantity = quantity + 1 
        WHERE user_id = :user AND product_id = :product
    ");
    $update->execute([
        'user' => $userId,
        'product' => $productId
    ]);
} else {
    /* insert new cart item */
    $insert = $pdo->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (:user, :product, 1)
    ");
    $insert->execute([
        'user' => $userId,
        'product' => $productId
    ]);
}

header('Location: cart.php');
exit;

?>
