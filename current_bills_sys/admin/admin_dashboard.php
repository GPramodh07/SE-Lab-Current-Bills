<?php 
    include('../connection/connect.php');
    session_start();

    if(isset($_SESSION['login_id']))
    {
        header("Location: ../home/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<header>
    <div class="titles">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>ELECTRIC DEPARTMENT</h2>
    </div>

    <div class="buttons">
        <button onclick="window.location.href='../connection/logout.php'">Logout</button>
    </div>
</header>
<hr><br>
<h2>Admin Dashboard</h2>

<div class="mid">
    <div class="box">
        <h2>Admin Registration</h2>
        <p>Want to add new admin?</p>
        <button><a href="admin_reg.php">Add Admin</a></button>
    </div>

    <div class="box">
        <h2>Supervisor Registration</h2>
        <p>Want to add supervisor?</p>
        <button><a href="supervisor_reg.php">Add Supervisor</a></button>
    </div>

    <div class="box">
        <h2>Customer Registration</h2>
        <p>Want to add new customer?</p>
        <button><a href="user_reg.php">Add Customer</a></button>
    </div>
</div>

</body>
</html>
