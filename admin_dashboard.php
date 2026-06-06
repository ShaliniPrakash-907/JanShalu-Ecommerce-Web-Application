<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users WHERE role='user'"))['count'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM orders WHERE status != 'Cancelled'"))['total'];

if ($total_revenue == NULL) {
    $total_revenue = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | JanShalu</title>

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
            width: 90%;
            margin: 40px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 42px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
        }

        .card {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px);
            padding: 30px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        .card h2 {
            font-size: 38px;
            color: #c4b5fd;
            margin-bottom: 8px;
        }

        .card p {
            color: #ddd6fe;
            font-weight: bold;
        }

        .actions {
            margin-top: 45px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 30px;
            background: #c4b5fd;
            color: #1e1235;
            text-decoration: none;
            font-weight: bold;
        }

        .btn:hover {
            background: #ddd6fe;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">🛒 JanShalu Admin</div>

    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a href="manage_orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <h1>Admin Dashboard</h1>

    <div class="cards">

        <div class="card">
            <h2><?php echo $total_users; ?></h2>
            <p>Users 👥</p>
        </div>

        <div class="card">
            <h2><?php echo $total_products; ?></h2>
            <p>Products 🛍️</p>
        </div>

        <div class="card">
            <h2><?php echo $total_orders; ?></h2>
            <p>Orders 📦</p>
        </div>

        <div class="card">
            <h2>₹<?php echo $total_revenue; ?></h2>
            <p>Revenue 💰</p>
        </div>

    </div>

    <div class="actions">
        <a href="add_product.php" class="btn">Add New Product</a>
        <a href="manage_products.php" class="btn">Manage Products</a>
        <a href="manage_orders.php" class="btn">Manage Orders</a>
    </div>

</div>

</body>
</html>