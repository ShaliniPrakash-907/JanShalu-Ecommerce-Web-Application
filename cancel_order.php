<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: my_orders.php");
    exit();
}

$order_id = intval($_GET['id']);

$check_order = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE id = $order_id 
    AND user_id = $user_id 
    AND status = 'Pending'
");

if (mysqli_num_rows($check_order) > 0) {

    mysqli_query($conn, "
        UPDATE orders 
        SET status = 'Cancelled' 
        WHERE id = $order_id 
        AND user_id = $user_id
    ");
}

header("Location: my_orders.php");
exit();
?>