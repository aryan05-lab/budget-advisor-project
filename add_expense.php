<?php
include "db.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if (isset($_POST['add'])) {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    $query = "INSERT INTO expenses (user_id, amount, category, date)
              VALUES (1, '$amount', '$category', '$date')";

    mysqli_query($conn, $query);

    $success = "Expense Added Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Expense</title>

    <style>
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #f8f6f1;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4a6741;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #3a5232;
        }

        .success {
            color: green;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #4a6741;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="box">

        <h2>Add New Expense</h2>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <form method="POST">
            <input type="number" name="amount" placeholder="Enter Amount" required>

            <select name="category">
               <option value="Food">Food</option>
               <option value="Travel">Travel</option>
               <option value="Shopping">Shopping</option>
               <option value="Bills">Bills</option>
               <option value="Other">Other</option>
</select>

            <input type="date" name="date" required>

            <button type="submit" name="add">Add Expense</button>
        </form>

        <a href="dashboard.php">← Back to Dashboard</a>
        <a href="index.php">← Go to Home</a>

    </div>

</div>

</body>
</html> 