<!-- code for removing items from cart functionality -->

<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

/* user needs to be logged in to use the cart */
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

/* checking item IDs, if missing redirects to cart */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: cart.php');
    exit;
}

/* prepare statement to delete cart item, must belong to currently logged in user */
$stmt = $pdo->prepare("
    DELETE FROM cart
    WHERE cart_id = ? AND user_id = ?
");
/* execute prepared statement using cart ID and user ID from the session */
$stmt->execute([
    (int)$_GET['id'],
    $_SESSION['user_id']
]);

/* redirects user back to cart once item deleted */
header('Location: cart.php');
exit;

?>