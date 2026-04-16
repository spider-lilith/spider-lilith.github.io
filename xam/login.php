<?php
require_once __DIR__ . '/includes/db.php';
?>

<body class="auth-page">

    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
<!-- wrapper used to center form -->
    <div class="auth-wrapper">
    <div class="auth-container">

        <h1>Log In</h1>

<!-- LOGIN FORM -->
        <form method="POST" class="auth-form">
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" class="red-btn">Log In</button>
        </form>

<!-- redirect users without an account -->
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

<?php
/* check if form is submitted */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

/* ----------------------------- 
sanitisation */
    /* remove whitespace */
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    /* validate email format */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error'>Please enter a valid email address</p>";
        exit;
    }

    /* prevent empty passwords */
    if (empty($password)) {
        echo "<p class='error'>Please enter your password</p>";
        exit;
    }


/* ----------------------------- 
fetch user from db */
    $stmt = $pdo->prepare("
        SELECT user_id, password, user_role
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


/* ----------------------------- 
password verify */
    if ($user && password_verify($password, $user['password'])) {

        /* store user details in session */
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];


/* ----------------------------- 
role-based redirect */
        if ($user['user_role'] === 'customer') {
            header('Location: user-dashboard.php');
            exit;
        }

        if ($user['user_role'] === 'producer') {
            header('Location: producer-dashboard.php');
            exit;
        }

        /* fallback if role is missing / something incorrect */
        header('Location: products.php');
        exit;

    } else {
        /* generic error msg */
        echo "<p class='error'>Invalid email or password</p>";
    }
}
?>