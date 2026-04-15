<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<h1>Create an Account</h1>

<form method="POST" class="auth-form">
    <input type="text" name="name" placeholder="Full name" required>

    <input type="email" name="email" placeholder="Email address" required>

    <input type="password" name="password" placeholder="Password" required>

    <select name="user_role" required>
        <option value="customer">Customer</option>
        <option value="producer">Producer</option>
    </select>

    <button type="submit" class="red-btn">Sign Up</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, user_role)
        VALUES (:name, :email, :password, :role)
    ");

    $stmt->execute([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => $_POST['user_role']
    ]);

    header('Location: login.php');
    exit;
}
?>