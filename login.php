<?php
session_start();
include 'db.php';

$message = "";

$email = "";

if(isset($_GET['email']))
{
    $email = $_GET['email'];
}

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0)
    {
        $user = mysqli_fetch_assoc($query);

        if(password_verify($password,$user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin')
            {
                header("Location: admin_dashboard.php");
            }
            else
            {
                header("Location: products.php");
            }
            exit();
        }
        else
        {
            $message = "Invalid Password!";
        }
    }
    else
    {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | JanShalu Cart</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:
radial-gradient(circle at top left, rgba(196,181,253,0.3), transparent 35%),
radial-gradient(circle at bottom right, rgba(167,139,250,0.3), transparent 35%),
linear-gradient(135deg,#0f1028,#251738,#3b235f);
}

.login-box{
width:420px;

background:rgba(255,255,255,0.12);
border:1px solid rgba(255,255,255,0.18);

backdrop-filter:blur(18px);
-webkit-backdrop-filter:blur(18px);

padding:40px;
border-radius:30px;

box-shadow:0 20px 60px rgba(0,0,0,0.35);

text-align:center;
color:white;
}

.logo{
font-size:30px;
font-weight:800;
margin-bottom:10px;
}

h2{
margin-bottom:10px;
}

.subtitle{
color:#ddd6fe;
margin-bottom:25px;
}

input{
width:100%;
padding:14px;
margin-bottom:15px;

border:none;
outline:none;

border-radius:14px;

background:rgba(255,255,255,0.12);
color:white;
font-size:15px;
}

input::placeholder{
color:#ddd6fe;
}

button{
width:100%;
padding:14px;

border:none;
border-radius:30px;

background:#c4b5fd;
color:#1e1235;

font-size:16px;
font-weight:700;

cursor:pointer;
transition:0.3s;
}

button:hover{
background:#ddd6fe;
transform:translateY(-3px);
}

.error{
background:rgba(255,0,0,0.15);
padding:10px;
border-radius:10px;
margin-bottom:15px;
color:#ffd1d1;
}

.links{
margin-top:20px;
font-size:14px;
}

.links a{
color:#c4b5fd;
text-decoration:none;
font-weight:600;
}

.links a:hover{
text-decoration:underline;
}

</style>

</head>
<body>

<div class="login-box">

<div class="logo">JanShalu Cart</div>

<h2>Welcome Back 👋</h2>

<p class="subtitle">
Login to continue shopping
</p>

<?php
if($message!="")
{
    echo "<div class='error'>$message</div>";
}
?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Email"
value="<?php echo $email; ?>"
required>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit" name="login">
Login
</button>

</form>

<div class="links">

<p>
Don't have an account?
<a href="register.php">Register</a>
</p>

<br>

<a href="index.php">
🏠 Back Home
</a>

</div>

</div>

</body>
</html>