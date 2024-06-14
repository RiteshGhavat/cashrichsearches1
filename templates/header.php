<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Header</title>
    <style>
        /* style.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(180deg, #fff 50%, #f4f4f4 50%); 
            color: #333;
            padding: 10px 0;
            border-bottom: 4px solid #555;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo-container {
            flex: 1;
            text-align: center;
        }

        .company-logo {
            max-height: 60px;
        }

        nav {
            flex: 2; 
            text-align: right; 
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end; 
            align-items: center;
        }

        .nav-menu li {
            margin-left: 20px;
        }

        .nav-menu li:first-child {
            margin-left: 0; 
        }

        .nav-menu li a {
            color: #333;
            text-decoration: none;
        }

        .nav-menu li a:hover {
            text-decoration: underline;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-left: 20px; 
        }

        .username {
            margin: 0;
            font-size: 1em;
            color: #111; 
        }


        .btn-logout:hover {
            background-color: blue;
        }

        .btn-login-signup {
            display: none; 
        }

        <?php if (!isset($_SESSION['user_id']) && (basename($_SERVER['PHP_SELF']) === 'login.php' || basename($_SERVER['PHP_SELF']) === 'signup.php' || basename($_SERVER['PHP_SELF']) === 'index.php')): ?>
        .btn-login-signup {
            display: block; 
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo-container">
                <a href="index.php"><img src="img/Cashrich_logo_1.png" alt="Company Logo" class="company-logo"></a>
            </div>
            <nav>
                <ul class="nav-menu">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="search.php">Search</a></li>
                        <li class="user-info">
                            <p class="username"><?= $_SESSION['user_name'] ?></p>
                            <a href="logout.php" class="btn-logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <?php if (basename($_SERVER['PHP_SELF']) !== 'index.php'): ?>
                            <li><a href="index.php" class="btn-login-signup">Home</a></li>
                        <?php endif; ?>
                        <li><a href="login.php" class="btn-login-signup">Login</a></li>
                        <li><a href="signup.php" class="btn-login-signup">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
