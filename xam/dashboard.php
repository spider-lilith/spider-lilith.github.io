<!-- code for redirecting to dashboards - new dashboards must be added here if created to redirect -->

<?php
require_once __DIR__ . '/includes/session.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

switch ($_SESSION['user_role']) {
    case 'producer':
        require __DIR__ . '/includes/dashboards/producer-dashboard.php';
        break;

    case 'admin':
        require __DIR__ . '/includes/dashboards/admin-dashboard.php';
        break;

    case 'customer':
        require __DIR__ . '/includes/dashboards/user-dashboard.php';
        break;

    default:
        exit('Invalid role');
}

?>