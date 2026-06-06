<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JanShalu | E-Commerce Platform</title>

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
            overflow-x: hidden;
        }

        .navbar {
            width: 100%;
            padding: 24px 8%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brand {
            font-size: 30px;
            font-weight: 800;
            color: #f5f3ff;
            letter-spacing: 1px;
        }

        .main {
            min-height: calc(100vh - 90px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 8%;
        }

        .glass-card {
            width: 100%;
            max-width: 1050px;
            padding: 55px 45px;
            text-align: center;
            border-radius: 35px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            background: rgba(196, 181, 253, 0.35);
            border-radius: 50%;
            top: -90px;
            right: -70px;
        }

        .glass-card::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(221, 214, 254, 0.22);
            border-radius: 50%;
            bottom: -70px;
            left: -60px;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .emoji {
            font-size: 58px;
            margin-bottom: 15px;
            animation: float 3s ease-in-out infinite;
        }

        h1 {
            font-size: 58px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #ffffff;
        }

        h1 span {
            color: #c4b5fd;
        }

        .tagline {
            font-size: 21px;
            font-weight: 500;
            color: #ede9fe;
            margin-bottom: 20px;
        }

        .description {
            max-width: 780px;
            margin: 0 auto 35px;
            font-size: 16px;
            line-height: 1.8;
            color: #ddd6fe;
        }

        .portal-container {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }

        .portal-card {
            width: 340px;
            padding: 32px 26px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.22);
            transition: 0.3s;
        }

        .portal-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.14);
        }

        .portal-card h2 {
            font-size: 26px;
            margin-bottom: 14px;
            color: #c4b5fd;
        }

        .portal-card p {
            color: #ddd6fe;
            line-height: 1.7;
            font-size: 15px;
            margin-bottom: 22px;
        }

        .btn {
            display: inline-block;
            padding: 13px 28px;
            border-radius: 35px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            font-size: 15px;
            margin: 6px;
        }

        .login-btn {
            background: #c4b5fd;
            color: #1e1235;
            box-shadow: 0 10px 30px rgba(196, 181, 253, 0.35);
        }

        .register-btn {
            background: transparent;
            color: #fff;
            border: 2px solid #c4b5fd;
        }

        .admin-btn {
            background: #ddd6fe;
            color: #1e1235;
            box-shadow: 0 10px 30px rgba(221, 214, 254, 0.28);
        }

        .btn:hover {
            transform: translateY(-5px);
        }

        .login-btn:hover,
        .admin-btn:hover {
            background: #ede9fe;
        }

        .register-btn:hover {
            background: #c4b5fd;
            color: #1e1235;
        }

        .admin-note {
            margin-top: 12px;
            color: #c4b5fd;
            font-size: 13px;
            font-weight: 600;
        }

        .mini-icons {
            font-size: 28px;
            letter-spacing: 12px;
            opacity: 0.95;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-12px);
            }
        }

        @media(max-width: 768px) {
            .glass-card {
                padding: 42px 22px;
            }

            h1 {
                font-size: 40px;
            }

            .tagline {
                font-size: 17px;
            }

            .description {
                font-size: 14px;
            }

            .brand {
                font-size: 24px;
            }

            .portal-card {
                width: 100%;
            }

            .mini-icons {
                letter-spacing: 6px;
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="brand">🛒 JanShalu</div>
    </nav>

    <main class="main">
        <section class="glass-card">
            <div class="content">

                <div class="emoji">🛍️✨</div>

                <h1>Welcome to <span>JanShalu</span></h1>

                <p class="tagline">
                    Modern E-Commerce Shopping Platform
                </p>

                <p class="description">
                    JanShalu is a full-stack shopping website where customers can explore products,
                    add items to cart, checkout securely, and track orders. Admin can manage products,
                    monitor orders, update delivery status, and control store inventory.
                </p>

                <div class="portal-container">

                    <div class="portal-card">
                        <h2>👤 User Portal</h2>

                        <p>
                            Explore products, add items to cart,
                            place orders and track your shopping history.
                        </p>

                        <a href="login.php" class="btn login-btn">User Login</a>
                        <a href="register.php" class="btn register-btn">Register</a>
                    </div>

                    <div class="portal-card">
                        <h2>👨‍💼 Admin Portal</h2>

                        <p>
                            Manage products, update stock,
                            view customer orders and track store revenue.
                        </p>

                        <a href="admin_login.php" class="btn admin-btn">Admin Login</a>

                        <p class="admin-note">
                            Admin access only
                        </p>
                    </div>

                </div>

                <div class="mini-icons">
                    👗 👜 👟 🎧 📱 🛒
                </div>

            </div>
        </section>
    </main>

</body>
</html>