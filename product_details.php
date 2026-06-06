<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");

if (mysqli_num_rows($query) == 0) {
    header("Location: products.php");
    exit();
}

$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?> | JanShalu</title>

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

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
        }

        .details-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px);
            padding: 35px;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .details-box img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 25px;
        }

        .info h1 {
            font-size: 38px;
            margin-bottom: 15px;
            color: #f5f3ff;
        }

        .desc {
            color: #ddd6fe;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .price {
            font-size: 32px;
            font-weight: 800;
            color: #c4b5fd;
            margin-bottom: 15px;
        }

        .stock {
            margin-bottom: 25px;
            color: #bbf7d0;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 800;
            margin-right: 12px;
        }

        .cart-btn {
            background: #c4b5fd;
            color: #1e1235;
        }

        .back-btn {
            border: 2px solid #c4b5fd;
            color: white;
        }

        @media(max-width: 768px) {
            .details-box {
                grid-template-columns: 1fr;
            }

            .details-box img {
                height: 300px;
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
        <a href="my_orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <div class="details-box">

        <img src="images/<?php echo $product['image']; ?>">

        <div class="info">

            <h1><?php echo $product['name']; ?></h1>

            <p class="desc"><?php echo $product['description']; ?></p>

            <div class="price">₹<?php echo $product['price']; ?></div>

            <div class="stock">
                Available Stock: <?php echo $product['stock']; ?>
            </div>

            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn cart-btn">
                🛒 Add to Cart
            </a>

            <a href="products.php" class="btn back-btn">
                ← Back
            </a>

        </div>

    </div>

</div>

</body>
</html>