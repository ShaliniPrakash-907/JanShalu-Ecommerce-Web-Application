<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header("Location: cart.php");
    exit();
}

$cart_id = intval($_GET['id']);
$action = $_GET['action'];

$cart_query = mysqli_query($conn, "
    SELECT * FROM cart 
    WHERE id = $cart_id AND user_id = $user_id
");

if (mysqli_num_rows($cart_query) == 0) {
    header("Location: cart.php");
    exit();
}

$cart_item = mysqli_fetch_assoc($cart_query);

if ($action == "increase") {

    mysqli_query($conn, "
        UPDATE cart 
        SET quantity = quantity + 1 
        WHERE id = $cart_id AND user_id = $user_id
    ");

} elseif ($action == "decrease") {

    if ($cart_item['quantity'] > 1) {
        mysqli_query($conn, "
            UPDATE cart 
            SET quantity = quantity - 1 
            WHERE id = $cart_id AND user_id = $user_id
        ");
    } else {
        mysqli_query($conn, "
            DELETE FROM cart 
            WHERE id = $cart_id AND user_id = $user_id
        ");
    }

} elseif ($action == "remove") {

    mysqli_query($conn, "
        DELETE FROM cart 
        WHERE id = $cart_id AND user_id = $user_id
    ");
}

header("Location: cart.php");
exit();
?>