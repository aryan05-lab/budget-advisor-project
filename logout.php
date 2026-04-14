<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>

    <style>
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #fdfcf9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h2 {
            font-family: 'Playfair Display', serif;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #4a6741;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #3a5232;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>You have been logged out</h2>
    <a href="login.php">Login Again</a>
</div>

</body>
</html>