<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // delete expense
    mysqli_query($conn, "DELETE FROM expenses WHERE id=$id");
}

// go back to dashboard
header("Location: dashboard.php");
?>