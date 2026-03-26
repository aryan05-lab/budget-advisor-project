<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: white;
            padding: 20px;
        }
        .top {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            background: red;
            padding: 10px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="top">
    <h2>Welcome <?php echo $_SESSION['user']; ?></h2>
    <a href="logout.php" class="btn">Logout</a>
</div>

<hr>

<h3>Dashboard Overview</h3>
<p>Your financial data will appear here.</p>

</body>
</html>