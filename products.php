<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $products = mysqli_query($conn,
        "SELECT * FROM products
        WHERE name LIKE '%$search%'
        OR description LIKE '%$search%'"
    );
} else {
    $products = mysqli_query($conn, "SELECT * FROM products");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Products | JanShalu</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background:
    radial-gradient(circle at top left, rgba(196,181,253,0.3), transparent 35%),
    radial-gradient(circle at bottom right, rgba(167,139,250,0.3), transparent 35%),
    linear-gradient(135deg,#0f1028,#251738,#3b235f);
    min-height: 100vh;
    color: white;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 8%;
}

.logo {
    font-size: 28px;
    font-weight: 800;
}

.nav-links a {
    text-decoration: none;
    color: white;
    margin-left: 20px;
    font-weight: 600;
}

.nav-links a:hover {
    color: #c4b5fd;
}

.container {
    width: 90%;
    margin: auto;
    padding-bottom: 50px;
}

.user {
    text-align: center;
    margin-bottom: 20px;
    color: #ddd6fe;
}

.heading {
    text-align: center;
    font-size: 40px;
    margin: 20px 0;
}

.search-box {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
}

.search-box input {
    width: 450px;
    padding: 14px;
    border: none;
    outline: none;
    border-radius: 15px 0 0 15px;
    background: rgba(255,255,255,0.12);
    color: white;
}

.search-box input::placeholder {
    color: #ddd6fe;
}

.search-box button {
    padding: 14px 25px;
    border: none;
    background: #c4b5fd;
    color: #1e1235;
    font-weight: 700;
    cursor: pointer;
    border-radius: 0 15px 15px 0;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap: 25px;
}

.card {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(18px);
    padding: 20px;
    border-radius: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-8px);
}

.card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 18px;
}

.card h3 {
    margin-top: 15px;
}

.desc {
    color: #ddd6fe;
    margin-top: 10px;
    font-size: 14px;
}

.price {
    font-size: 22px;
    font-weight: 700;
    color: #c4b5fd;
    margin-top: 15px;
}

.stock {
    margin-top: 10px;
    color: #bbf7d0;
}

.details-btn,
.cart-btn {
    display: block;
    width: 100%;
    margin-top: 14px;
    padding: 12px;
    text-align: center;
    text-decoration: none;
    font-weight: 700;
    border-radius: 15px;
    transition: 0.3s;
}

.details-btn {
    background: transparent;
    color: white;
    border: 2px solid #c4b5fd;
}

.cart-btn {
    background: #c4b5fd;
    color: #1e1235;
}

.details-btn:hover,
.cart-btn:hover {
    background: #ddd6fe;
    color: #1e1235;
}

.empty {
    text-align: center;
    color: #ddd6fe;
    font-size: 20px;
    margin-top: 40px;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 JanShalu</div>

    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="my_orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="user">
        Welcome, <b><?php echo $_SESSION['user_name']; ?></b> 👋
    </div>

    <h1 class="heading">🛍️ Our Products</h1>

    <form method="GET" class="search-box">
        <input
            type="text"
            name="search"
            placeholder="Search Products..."
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <button type="submit">🔍 Search</button>
    </form>

    <div class="product-grid">

        <?php if (mysqli_num_rows($products) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($products)) { ?>

                <div class="card">

                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">

                    <h3><?php echo $row['name']; ?></h3>

                    <p class="desc"><?php echo $row['description']; ?></p>

                    <div class="price">₹<?php echo $row['price']; ?></div>

                    <div class="stock">Stock: <?php echo $row['stock']; ?></div>

                    <a href="product_details.php?id=<?php echo $row['id']; ?>" class="details-btn">
                        View Details
                    </a>

                    <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="cart-btn">
                        🛒 Add To Cart
                    </a>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="empty">
                No products found.
            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>