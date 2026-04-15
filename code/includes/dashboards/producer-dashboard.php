<?php

if ($_SESSION['user_role'] !== 'producer') {
    exit('Access denied');
}
?>

<form action="logout.php" method="post">
    <button type="submit" class="red-btn">Log out</button>
</form>