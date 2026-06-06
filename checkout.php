<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn, "
    SELECT cart.quantity, products.*
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");

if (mysqli_num_rows($cart_items) == 0) {
    header("Location: cart.php");
    exit();
}

$total = 0;
$items = [];

while ($row = mysqli_fetch_assoc($cart_items)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $items[] = $row;
}

if (isset($_POST['place_order'])) {

    mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, status) 
                         VALUES ($user_id, $total, 'Pending')");

    $order_id = mysqli_insert_id($conn);

    foreach ($items as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price)
                             VALUES ($order_id, $product_id, $quantity, $price)");

        mysqli_query($conn, "UPDATE products 
                             SET stock = stock - $quantity 
                             WHERE id = $product_id");
    }

    mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

    header("Location: my_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout | JanShalu</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg,#0f1028,#251738,#3b235f);
            color: white;
            font-family: Poppins, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 500px;
            padding: 35px;
            border-radius: 25px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(18px);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        .total {
            font-size: 28px;
            color: #c4b5fd;
            margin: 25px 0;
            font-weight: bold;
        }

        button, a {
            display: inline-block;
            padding: 13px 28px;
            border-radius: 30px;
            border: none;
            text-decoration: none;
            font-weight: bold;
            margin: 8px;
        }

        button {
            background: #c4b5fd;
            color: #1e1235;
            cursor: pointer;
        }

        a {
            border: 2px solid #c4b5fd;
            color: white;
        }
    </style>
</head>

<body>

<div class="box">
    <h1>Checkout 🛒</h1>

    <p>Confirm your order and place it securely.</p>

    <div class="total">
        Total Amount: ₹<?php echo $total; ?>
    </div>

    <form method="POST">
        <button type="submit" name="place_order">
            Place Order 📦
        </button>
    </form>

    <a href="cart.php">Back to Cart</a>
</div>

</body>
</html>