<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = intval($_GET['id']);

$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");

if (mysqli_num_rows($product_query) == 0) {
    header("Location: manage_products.php");
    exit();
}

$product = mysqli_fetch_assoc($product_query);
$message = "";

if (isset($_POST['update_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($image_tmp, "images/" . $image_name);
    } else {
        $image_name = $product['image'];
    }

    $update = mysqli_query($conn, "
        UPDATE products 
        SET name='$name',
            description='$description',
            price='$price',
            image='$image_name',
            stock='$stock'
        WHERE id=$id
    ");

    if ($update) {
        header("Location: manage_products.php");
        exit();
    } else {
        $message = "Product update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product | JanShalu</title>

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
            width: 460px;
            margin: 45px auto;
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

        textarea {
            height: 100px;
        }

        input::placeholder, textarea::placeholder {
            color: #ddd6fe;
        }

        img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 18px;
            margin-bottom: 15px;
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

        button:hover {
            background: #ddd6fe;
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

    <h2>Edit Product ✏️</h2>

    <?php if ($message != "") { ?>
        <p class="msg"><?php echo $message; ?></p>
    <?php } ?>

    <img src="images/<?php echo $product['image']; ?>">

    <form method="POST" enctype="multipart/form-data">

        <input 
            type="text" 
            name="name" 
            value="<?php echo $product['name']; ?>" 
            required
        >

        <textarea name="description" required><?php echo $product['description']; ?></textarea>

        <input 
            type="number" 
            name="price" 
            value="<?php echo $product['price']; ?>" 
            required
        >

        <input 
            type="number" 
            name="stock" 
            value="<?php echo $product['stock']; ?>" 
            required
        >

        <input type="file" name="image">

        <button type="submit" name="update_product">Update Product</button>

    </form>

    <a href="manage_products.php">← Back to Products</a>

</div>

</body>
</html>