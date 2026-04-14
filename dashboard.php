<?php
include "db.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$email = $_SESSION['user'];

// Greeting
date_default_timezone_set("Asia/Kolkata");
$hour = date("H");
if ($hour < 12) $greeting = "Good Morning";
elseif ($hour < 18) $greeting = "Good Afternoon";
else $greeting = "Good Evening";

// Total expenses
$total_query = "SELECT SUM(amount) AS total FROM expenses";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'] ? $total_row['total'] : 0;

// Transaction count
$count_query = "SELECT COUNT(*) AS count FROM expenses";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$count = $count_row['count'];

// Recent expenses
$recent_query = "SELECT * FROM expenses ORDER BY id DESC LIMIT 5";
$recent_result = mysqli_query($conn, $recent_query);

// Category summary
$category_query = "SELECT category, SUM(amount) as total FROM expenses GROUP BY category";
$category_result = mysqli_query($conn, $category_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #f8f6f1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .buttons a {
            text-decoration: none;
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 6px;
            color: white;
        }

        .add-btn {
            background: #4a6741;
        }

        .logout-btn {
            background: #d11a2a;
        }

        .container {
            padding: 30px 40px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 220px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .card p {
            font-size: 24px;
            margin: 10px 0 0;
            color: #4a6741;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        th {
            background: #4a6741;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .subtitle {
            color: #555;
            margin-bottom: 20px;
        }

        .delete-btn {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="header">
    <div class="title">
        <?php echo $greeting; ?>, <?php echo $email; ?> 👋
    </div>

    <div class="buttons">
         <a href="index.php" class="add-btn">Home</a>
         <a href="add_expense.php" class="add-btn">Add New Expense</a>
         <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">

    <h2>Your Financial Overview</h2>
    <p class="subtitle">Track your spending and manage your budget effectively.</p>

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <h4>Total Expenses</h4>
            <p>₹ <?php echo $total; ?></p>
        </div>

        <div class="card">
            <h4>Number of Transactions</h4>
            <p><?php echo $count; ?></p>
        </div>
    </div>

    <!-- Recent Expenses -->
    <h2 style="margin-top:40px;">Recent Expenses</h2>

    <table>
        <tr>
            <th>Amount</th>
            <th>Category</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($recent_result)) { ?>
        <tr>
            <td>₹ <?php echo $row['amount']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td>
                <a href="delete.php?id=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Delete this expense?')" 
                   class="delete-btn">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Category Summary -->
    <h2 style="margin-top:40px;">Spending by Category</h2>

    <table>
        <tr>
            <th>Category</th>
            <th>Total Spent</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($category_result)) { ?>
        <tr>
            <td><?php echo $row['category']; ?></td>
            <td>₹ <?php echo $row['total']; ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>