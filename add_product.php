<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $image_folder = "images/" . $image_name;

    if (move_uploaded_file($image_tmp, $image_folder)) {

        $insert = mysqli_query($conn, "
            INSERT INTO products(name, description, price, image, stock)
            VALUES('$name', '$description', '$price', '$image_name', '$stock')
        ");

        if ($insert) {
            header("Location: manage_products.php");
            exit();
        } else {
            $message = "Product not added!";
        }

    } else {
        $message = "Image upload failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product | JanShalu</title>

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

        .box {
            width: 450px;
            margin: 60px auto;
            padding: 35px;
            border-radius: 25px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(18px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            margin-bottom: 15px;
            border-radius: 14px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.14);
            color: white;
        }

        input::placeholder, textarea::placeholder {
            color: #ddd6fe;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: #c4b5fd;
            color: #1e1235;
            font-weight: bold;
            cursor: pointer;
        }

        .msg {
            text-align: center;
            color: #fecaca;
            margin-bottom: 15px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #c4b5fd;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Add Product 🛍️</h2>

    <?php if ($message != "") { ?>
        <p class="msg"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Product Name" required>

        <textarea name="description" placeholder="Product Description" required></textarea>

        <input type="number" name="price" placeholder="Price" required>

        <input type="number" name="stock" placeholder="Stock" required>

        <input type="file" name="image" required>

        <button type="submit" name="add_product">Add Product</button>

    </form>

    <a href="manage_products.php">← Back to Products</a>

</div>

</body>
</html>