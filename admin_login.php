<?php
session_start();
include 'db.php';

$message = "";

if (isset($_POST['admin_login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE email='$email' AND role='admin'
        LIMIT 1
    ");

    if (mysqli_num_rows($query) > 0) {

        $admin = mysqli_fetch_assoc($query);

        if ($password == $admin['password']) {

            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_name'] = $admin['name'];
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['role'] = $admin['role'];

            header("Location: admin_dashboard.php");
            exit();

        } else {
            $message = "Invalid Admin Password!";
        }

    } else {
        $message = "Admin account not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | JanShalu</title>

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
    display: flex;
    justify-content: center;
    align-items: center;
    background:
    radial-gradient(circle at top left, rgba(196,181,253,0.3), transparent 35%),
    radial-gradient(circle at bottom right, rgba(167,139,250,0.3), transparent 35%),
    linear-gradient(135deg,#0f1028,#251738,#3b235f);
}

.login-box {
    width: 420px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(18px);
    padding: 40px;
    border-radius: 30px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.35);
    text-align: center;
    color: white;
}

.logo {
    font-size: 30px;
    font-weight: 800;
    margin-bottom: 10px;
}

.subtitle {
    color: #ddd6fe;
    margin-bottom: 25px;
}

input {
    width: 100%;
    padding: 14px;
    margin-bottom: 15px;
    border: none;
    outline: none;
    border-radius: 14px;
    background: rgba(255,255,255,0.12);
    color: white;
}

input::placeholder {
    color: #ddd6fe;
}

button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 30px;
    background: #ddd6fe;
    color: #1e1235;
    font-weight: 800;
    cursor: pointer;
}

.error {
    background: rgba(255,0,0,0.15);
    color: #ffd1d1;
    padding: 10px;
    border-radius: 12px;
    margin-bottom: 15px;
}

.links {
    margin-top: 20px;
}

.links a {
    color: #c4b5fd;
    text-decoration: none;
    font-weight: 600;
}
</style>
</head>

<body>

<div class="login-box">

    <div class="logo">👨‍💼 JanShalu Admin</div>

    <p class="subtitle">Admin Login Panel</p>

    <?php if ($message != "") { ?>
        <div class="error"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>

        <input type="password" name="password" placeholder="Admin Password" required>

        <button type="submit" name="admin_login">
            Login as Admin
        </button>
    </form>

    <div class="links">
        <a href="index.php">← Back to Home</a>
    </div>

</div>

</body>
</html>