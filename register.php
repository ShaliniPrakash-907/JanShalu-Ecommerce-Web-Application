<?php
include 'db.php';

$message = "";

if (isset($_POST['register'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $message = "Passwords do not match!";
    } else {

        $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($check_email) > 0) {
            $message = "Email already registered!";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_query($conn, "INSERT INTO users (name, email, password, role) 
                                          VALUES ('$name', '$email', '$hashed_password', 'user')");

            if ($insert) {
                header("Location: login.php?email=" . urlencode($email));
                exit();
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | JanShalu</title>

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
                radial-gradient(circle at top left, rgba(196, 181, 253, 0.35), transparent 35%),
                radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.35), transparent 35%),
                linear-gradient(135deg, #0f1028, #251738, #3b235f);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .register-box {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            text-align: center;
        }

        .logo {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #f5f3ff;
        }

        h2 {
            margin-bottom: 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #ddd6fe;
            margin-bottom: 25px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 16px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            outline: none;
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            font-size: 15px;
        }

        input::placeholder {
            color: #ddd6fe;
        }

        input:focus {
            border-color: #c4b5fd;
            box-shadow: 0 0 0 3px rgba(196, 181, 253, 0.18);
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: #c4b5fd;
            color: #1e1235;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 5px;
        }

        button:hover {
            background: #ddd6fe;
            transform: translateY(-3px);
        }

        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.18);
            color: #fecaca;
            font-size: 14px;
        }

        .login-link {
            margin-top: 22px;
            color: #ddd6fe;
            font-size: 14px;
        }

        .login-link a {
            color: #c4b5fd;
            text-decoration: none;
            font-weight: 700;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .home-link {
            display: inline-block;
            margin-top: 18px;
            color: #ede9fe;
            text-decoration: none;
            font-size: 14px;
        }

        .home-link:hover {
            color: #c4b5fd;
        }
    </style>
</head>

<body>

    <div class="register-box">

        <div class="logo">🛒 JanShalu</div>

        <h2>Create Account</h2>

        <p class="subtitle">Register now and start shopping 🛍️</p>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <form method="POST" action="">

            <input type="text" name="name" placeholder="Enter your name" required>

            <input type="email" name="email" placeholder="Enter your email" required>

            <input type="password" name="password" placeholder="Create password" required>

            <input type="password" name="confirm_password" placeholder="Confirm password" required>

            <button type="submit" name="register">Register</button>

        </form>

        <p class="login-link">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

        <a href="index.php" class="home-link">← Back to Home</a>

    </div>

</body>
</html>