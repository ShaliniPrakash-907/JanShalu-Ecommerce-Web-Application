<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "
        UPDATE orders 
        SET status='$status' 
        WHERE id=$order_id
    ");

    header("Location: manage_orders.php");
    exit();
}

$orders = mysqli_query($conn, "
    SELECT orders.*, users.name, users.email
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders | JanShalu</title>

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

        .logo {
            font-size: 28px;
            font-weight: 800;
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

        .container {
            width: 92%;
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
            border-radius: 25px;
            margin-bottom: 25px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        .order-card h3 {
            color: #c4b5fd;
            margin-bottom: 10px;
        }

        .order-card p {
            margin: 8px 0;
            color: #ede9fe;
        }

        table {
            width: 100%;
            margin-top: 18px;
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

        select {
            padding: 10px;
            border-radius: 12px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.18);
            color: white;
        }

        select option {
            color: black;
        }

        button {
            padding: 10px 18px;
            border: none;
            border-radius: 20px;
            background: #c4b5fd;
            color: #1e1235;
            font-weight: bold;
            cursor: pointer;
            margin-left: 8px;
        }

        button:hover {
            background: #ddd6fe;
        }

        .empty {
            text-align: center;
            color: #ddd6fe;
            margin-top: 60px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">🛒 JanShalu Admin</div>

    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_products.php">Products</a>
        <a href="add_product.php">Add Product</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <h1>Manage Orders 📦</h1>

    <?php if (mysqli_num_rows($orders) > 0) { ?>

        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>

            <div class="order-card">

                <h3>Order ID: #<?php echo $order['id']; ?></h3>

                <p><b>User:</b> <?php echo $order['name']; ?></p>
                <p><b>Email:</b> <?php echo $order['email']; ?></p>
                <p><b>Total:</b> ₹<?php echo $order['total_amount']; ?></p>
                <p><b>Date:</b> <?php echo $order['order_date']; ?></p>

                <form method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

                    <select name="status">
                        <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="Cancelled" <?php if ($order['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>

                    <button type="submit" name="update_status">Update Status</button>
                </form>

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

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="empty">
            <h2>No orders found 📦</h2>
        </div>

    <?php } ?>

</div>

</body>
</html>