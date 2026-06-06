<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = intval($_GET['id']);

// Optional: get image name before deleting product
$product_query = mysqli_query($conn, "SELECT image FROM products WHERE id = $id");

if (mysqli_num_rows($product_query) > 0) {
    $product = mysqli_fetch_assoc($product_query);
    $image_path = "images/" . $product['image'];

    // Delete product image from folder if exists
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete product from database
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
}

header("Location: manage_products.php");
exit();
?>