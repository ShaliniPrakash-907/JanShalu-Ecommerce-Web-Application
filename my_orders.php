<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE user_id = $user_id 
    ORDER BY order_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders | JanShalu</title>

    <style>
        body {
            min-height: 100vh;
            background:
            radial-gradient(circle at top left, rgba(196,181,253,0.3), transparent 35%),
            radial-gradient(circle at bottom right, rgba(167,139,250,0.3), transparent 35%),
            linear-gradient(135deg,#0f1028,#251738,#3b235f);
            color: white;
            font-family: Poppins, Arial, sans-serif;
        }

        .navbar {
            padding: 22px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #ddd6fe;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #c4b5fd;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
        }

        .container {
            width: 90%;
            margin: 40px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 42px;
        }

        .order-card {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px);
            padding: 25px;
            border-radius: 22px;
            margin-bottom: 22px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        .order-card h3 {
            color: #c4b5fd;
            margin-bottom: 12px;
        }

        .order-card p {
            margin: 8px 0;
            color: #ede9fe;
        }

        .status {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: bold;
            margin-left: 5px;
        }

        .pending {
            background: rgba(250,204,21,0.18);
            color: #fde68a;
        }

        .cancelled {
            background: rgba(239,68,68,0.18);
            color: #fecaca;
        }

        .delivered {
            background: rgba(34,197,94,0.18);
            color: #bbf7d0;
        }

        .shipped {
            background: rgba(59,130,246,0.18);
            color: #bfdbfe;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            text-align: center;
        }

        th {
            color: #c4b5fd;
        }

        .cancel-btn {
            display: inline-block;
            margin-top: 18px;
            padding: 11px 24px;
            background: rgba(239,68,68,0.18);
            color: #fecaca;
            border: 1px solid rgba(239,68,68,0.45);
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #ef4444;
            color: white;
        }

        .empty {
            text-align: center;
            color: #ddd6fe;
            margin-top: 60px;
        }

        .shop-link {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 26px;
            border-radius: 25px;
            background: #c4b5fd;
            color: #1e1235;
            text-decoration: none;
            font-weight: bold;
        }

        @media(max-width:768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            table {
                font-size: 13px;
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
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <h1>📦 My Orders</h1>

    <?php if (mysqli_num_rows($orders) > 0) { ?>

        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>

            <?php
                $status_class = strtolower($order['status']);
            ?>

            <div class="order-card">

                <h3>Order ID: #<?php echo $order['id']; ?></h3>

                <p><b>Total Amount:</b> ₹<?php echo $order['total_amount']; ?></p>

                <p>
                    <b>Status:</b>
                    <span class="status <?php echo $status_class; ?>">
                        <?php echo $order['status']; ?>
                    </span>
                </p>

                <p><b>Order Date:</b> <?php echo $order['order_date']; ?></p>

                <?php
                $order_id = $order['id'];

                $items = mysqli_query($conn, "
                    SELECT order_items.*, products.name
                    FROM order_items
                    JOIN products ON order_items.product_id = products.id
                    WHERE order_items.order_id = $order_id
                ");
                ?>

                <table>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>

                    <?php while ($item = mysqli_fetch_assoc($items)) { ?>

                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo $item['price']; ?></td>
                            <td>₹<?php echo $item['quantity'] * $item['price']; ?></td>
                        </tr>

                    <?php } ?>

                </table>

                <?php if ($order['status'] == 'Pending') { ?>
                    <a 
                        href="cancel_order.php?id=<?php echo $order['id']; ?>" 
                        class="cancel-btn"
                        onclick="return confirm('Are you sure you want to cancel this order?');"
                    >
                        Cancel Order
                    </a>
                <?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="empty">
            <h2>No orders yet 🛍️</h2>
            <a href="products.php" class="shop-link">Start Shopping</a>
        </div>

    <?php } ?>

</div>

</body>
</html>