<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<h1>Log In</h1>

<form method="POST" class="auth-form">
    <input type="email" name="email" placeholder="Email address" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" class="red-btn">Log In</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        SELECT user_id, password, user_role
        FROM users
        WHERE email = :email
    ");
    $stmt->execute(['email' => $_POST['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];

        header('Location: products.php');
        exit;
    } else {
        echo "<p class='error'>Invalid email or password</p>";
    }
}
?>