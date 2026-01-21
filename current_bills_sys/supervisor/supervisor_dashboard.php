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
    <link rel="stylesheet" href="supervisor_dashboard.css">
</head>
<body>

<header>
    <div class="titles">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>ELECTRIC DEPARTMENT</h2>
    </div>

    <div class="buttons">
        <!-- <button onclick="window.location.href='../home/login.php'">Back</button> -->
        <button onclick="window.location.href='../connection/logout.php'">Logout</button>
    </div>
</header>
<hr><br>
<h2>Hello Supervisor</h2>

<div class="mid">
    <!-- <div class="box">
        <h2>Users Data</h2>
        <p>Want to access all users?</p>
        <button onclick="window.location.href='all_data.php'" style="color: white;">Data</button>
    </div> -->

    <div class="box">
        <h2>Meter Reading</h2>
        <p>Want to generate bills?</p>
        <button onclick="window.location.href='readings.php'" style="color: white;">Take Reading</button>
    </div>
</div>

</body>
</html>
