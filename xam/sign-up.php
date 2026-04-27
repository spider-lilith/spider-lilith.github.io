<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* sanitisation */
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = $_POST['user_role'] ?? '';

    /* validation */
    if (empty($name)) {
        $error = 'Please enter your full name.';
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    }
    elseif (empty($password)) {
        $error = 'Please enter a password.';
    }
    elseif (!in_array($role, ['customer', 'producer'])) {
        $error = 'Invalid account type selected.';
    }
    else {
        /* insert user into db */
        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password, user_role)
            VALUES (:name, :email, :password, :role)
        ");

        $stmt->execute([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role
        ]);

        header('Location: login.php');
        exit;
    }
}
?>

<!-- --------------------------------------------------------------------------------- -->
<!-- PAGE CONTENT -->
<!-- --------------------------------------------------------------------------------- -->

<body class="auth-page">

    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <div class="auth-wrapper">
        <div class="auth-container">

            <h1>Sign Up</h1>

            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

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

            <div class="redirect">
                <p>
                    Already have an account?
                    <a href="<?= BASE_URL ?>login.php"
                        class="redirect-link"
                        aria-label="Log in to current account">
                        Log in
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
