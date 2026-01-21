<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
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
<hr>

<div class="mid">
    <div class="box">
        <h2>Bills History</h2>
        <p>Want to access previous bills?</p>
        <button onclick="window.location.href='user_bills_data.php'" style="color: white;">Bills</button>
    </div>

    <!-- <div class="box">
        <h2>Meter Reading</h2>
        <p>Want to generate bills?</p>
        <button onclick="window.location.href='#'" style="color: white;">Enter</button> -->
    </div>
</div>

</body>
</html>