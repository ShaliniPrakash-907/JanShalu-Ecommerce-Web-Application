<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products | JanShalu</title>

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

        .table-box {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px);
            padding: 25px;
            border-radius: 25px;
            overflow-x: auto;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            text-align: center;
        }

        th {
            color: #c4b5fd;
        }

        img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 14px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 3px;
        }

        .edit {
            background: #c4b5fd;
            color: #1e1235;
        }

        .delete {
            background: rgba(239,68,68,0.18);
            color: #fecaca;
            border: 1px solid rgba(239,68,68,0.45);
        }

        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 13px 28px;
            border-radius: 30px;
            background: #c4b5fd;
            color: #1e1235;
            text-decoration: none;
            font-weight: bold;
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

    <h1>Manage Products 🛍️</h1>

    <a href="add_product.php" class="add-btn">+ Add Product</a>

    <div class="table-box">

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($products)) { ?>

                <tr>
                    <td>
                        <img src="images/<?php echo $row['image']; ?>">
                    </td>

                    <td><?php echo $row['name']; ?></td>

                    <td>₹<?php echo $row['price']; ?></td>

                    <td><?php echo $row['stock']; ?></td>

                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>

                        <a 
                            href="delete_product.php?id=<?php echo $row['id']; ?>" 
                            class="btn delete"
                            onclick="return confirm('Are you sure you want to delete this product?');"
                        >
                            Delete
                        </a>
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>