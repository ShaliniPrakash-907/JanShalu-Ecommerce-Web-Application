<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn, "
    SELECT cart.id AS cart_id, cart.quantity, products.*
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart | JanShalu</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    background:
    radial-gradient(circle at top left, rgba(196,181,253,0.3), transparent 35%),
    radial-gradient(circle at bottom right, rgba(167,139,250,0.3), transparent 35%),
    linear-gradient(135deg,#0f1028,#251738,#3b235f);
    color: white;
}

.navbar {
    padding: 22px 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 28px;
    font-weight: 800;
}

.navbar a {
    color: #ddd6fe;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 600;
}

.navbar a:hover {
    color: #c4b5fd;
}

.container {
    width: 90%;
    max-width: 1050px;
    margin: 40px auto;
}

h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 42px;
}

.cart-box {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(18px);
    border-radius: 28px;
    padding: 25px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

th {
    color: #c4b5fd;
}

.product-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 14px;
}

.qty-box {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #c4b5fd;
    color: #1e1235;
    text-decoration: none;
    font-size: 20px;
    font-weight: 800;
    display: flex;
    justify-content: center;
    align-items: center;
}

.qty-btn:hover {
    background: #ddd6fe;
}

.qty-number {
    min-width: 30px;
    font-weight: 700;
    color: white;
}

.remove-btn {
    color: #fecaca;
    text-decoration: none;
    font-weight: 700;
}

.remove-btn:hover {
    color: #ef4444;
}

.total-box {
    margin-top: 25px;
    text-align: right;
}

.total-box h2 {
    margin-bottom: 20px;
}

.checkout-btn, .shop-btn {
    display: inline-block;
    padding: 13px 28px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    margin-left: 10px;
}

.checkout-btn {
    background: #c4b5fd;
    color: #1e1235;
}

.shop-btn {
    border: 2px solid #c4b5fd;
    color: white;
}

.checkout-btn:hover,
.shop-btn:hover {
    background: #ddd6fe;
    color: #1e1235;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #ddd6fe;
}

@media(max-width: 768px) {
    .navbar {
        flex-direction: column;
        gap: 15px;
    }

    table {
        min-width: 800px;
    }
}
</style>
</head>

<body>

<nav class="navbar">
    <div class="logo">🛒 JanShalu</div>

    <div>
        <a href="home.php">Home</a>
        <a href="products.php">Products</a>
        <a href="my_orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <h1>🛍️ My Cart</h1>

    <div class="cart-box">

        <?php if (mysqli_num_rows($cart_items) > 0) { ?>

        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Remove</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($cart_items)) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
            ?>

            <tr>
                <td>
                    <img src="images/<?php echo $row['image']; ?>" class="product-img">
                </td>

                <td><?php echo $row['name']; ?></td>

                <td>₹<?php echo $row['price']; ?></td>

                <td>
                    <div class="qty-box">
                        <a class="qty-btn" href="update_cart.php?id=<?php echo $row['cart_id']; ?>&action=decrease">−</a>

                        <span class="qty-number">
                            <?php echo $row['quantity']; ?>
                        </span>

                        <a class="qty-btn" href="update_cart.php?id=<?php echo $row['cart_id']; ?>&action=increase">+</a>
                    </div>
                </td>

                <td>₹<?php echo $subtotal; ?></td>

                <td>
                    <a class="remove-btn" href="update_cart.php?id=<?php echo $row['cart_id']; ?>&action=remove">
                        Remove
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>

        <div class="total-box">
            <h2>Total: ₹<?php echo $total; ?></h2>

            <a href="products.php" class="shop-btn">Continue Shopping</a>
            <a href="checkout.php" class="checkout-btn">Checkout</a>
        </div>

        <?php } else { ?>

            <div class="empty">
                <h2>Your cart is empty 🛒</h2>
                <br>
                <a href="products.php" class="checkout-btn">Shop Now</a>
            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>