<?php
// Simple homepage redirect
// If a user is logged in, send them to the customer dashboard; otherwise show products.
session_start();

if (!headers_sent()) {
    if (!empty($_SESSION['user_id'])) {
        header('Location: /customer_dashboard.php');
        exit;
    }
    header('Location: /products.php');
    exit;
}

// Fallback if headers already sent
if (!empty($_SESSION['user_id'])) {
    echo '<meta http-equiv="refresh" content="0;url=/customer_dashboard.php" />';
    exit;
}
echo '<meta http-equiv="refresh" content="0;url=/products.php" />';
exit;
