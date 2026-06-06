<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | JanShalu</title>

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
                radial-gradient(circle at top left, rgba(196,181,253,0.35), transparent 35%),
                radial-gradient(circle at bottom right, rgba(167,139,250,0.35), transparent 35%),
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
            margin-left: 22px;
            font-weight: 600;
        }

        .navbar a:hover {
            color: #c4b5fd;
        }

        .main {
            min-height: calc(100vh - 90px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 8%;
        }

        .glass-card {
            width: 100%;
            max-width: 900px;
            padding: 50px;
            text-align: center;
            border-radius: 35px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            box-shadow: 0 25px 80px rgba(0,0,0,0.35);
            backdrop-filter: blur(18px);
        }

        .emoji {
            font-size: 55px;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 45px;
            margin-bottom: 12px;
        }

        h1 span {
            color: #c4b5fd;
        }

        .text {
            color: #ddd6fe;
            font-size: 17px;
            margin-bottom: 30px;
        }

        .user-box {
            background: rgba(255,255,255,0.13);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 22px;
            padding: 25px;
            margin: 30px auto;
            max-width: 520px;
            text-align: left;
        }

        .user-box h3 {
            text-align: center;
            margin-bottom: 18px;
            color: #f5f3ff;
        }

        .user-box p {
            margin: 12px 0;
            color: #ede9fe;
            font-size: 16px;
        }

        .user-box strong {
            color: #c4b5fd;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 35px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .shop-btn {
            background: #c4b5fd;
            color: #1e1235;
        }

        .cart-btn {
            background: transparent;
            color: white;
            border: 2px solid #c4b5fd;
        }

        .order-btn {
            background: rgba(255,255,255,0.16);
            color: white;
            border: 1px solid rgba(255,255,255,0.25);
        }

        .btn:hover {
            transform: translateY(-5px);
            background: #ddd6fe;
            color: #1e1235;
        }

        @media(max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            h1 {
                font-size: 34px;
            }

            .glass-card {
                padding: 35px 22px;
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
        <a href="my_orders.php">My Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<main class="main">

    <section class="glass-card">

        <div class="emoji">🛍️✨</div>

        <h1>Hello, <span><?php echo $name; ?></span></h1>

        <p class="text">
            Welcome to JanShalu. Start shopping your favorite products today.
        </p>

        <div class="user-box">
            <h3>👤 User Details</h3>

            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst($role); ?></p>
        </div>

        <div class="buttons">
            <a href="products.php" class="btn shop-btn">Shop Now 🛒</a>
            <a href="cart.php" class="btn cart-btn">View Cart 🛍️</a>
            <a href="my_orders.php" class="btn order-btn">My Orders 📦</a>
        </div>

    </section>

</main>

</body>
</html>