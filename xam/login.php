<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

$error = null;

/* check if form is submitted */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* sanitisation */
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    /* validate email format */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    }

    /* prevent empty password */
    elseif (empty($password)) {
        $error = 'Please enter your password.';
    }

    /* fetch user from db */
    else {
        $stmt = $pdo->prepare("
            SELECT user_id, password, user_role
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        /* verify password */
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['user_role'] = $user['user_role'];

            header('Location: dashboard.php');
            exit;

        } else {
            $error = 'Invalid email or password.';
        }
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

            <h1>Log In</h1>

            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- LOGIN FORM -->
            <form method="POST" class="auth-form">
                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" class="red-btn">Log In</button>
            </form>

            <div class="redirect">
                <p>
                    Don't have an account with us?
                    <a href="<?= BASE_URL ?>sign-up.php"
                        class="redirect-link"
                        aria-label="Sign up for a new account">
                        Sign up here
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
