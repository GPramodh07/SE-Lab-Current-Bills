<?php 
    include('../connection/connect.php');
    session_start();

    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../home/login.php");
        exit();
    }

    $meter_id  = $_SESSION['meter_id'];
    $bill_id   = $_SESSION['bill_id'];
    $user_id   = $_SESSION['act_user_id'];
    $prev_read = $_SESSION['prev_read'];
    $cur_read  = $_SESSION['cur_read'];

    $q1 = "SELECT * FROM user WHERE user_id = '$user_id'";
    $r1 = mysqli_query($conn,$q1);
    $row1 = mysqli_fetch_assoc($r1);

    $q2 = "SELECT * FROM meter WHERE meter_id = '$meter_id'";
    $r2 = mysqli_query($conn,$q2);
    $row2 = mysqli_fetch_assoc($r2);

    $q3 = "SELECT * FROM bill WHERE bill_id = '$bill_id'";
    $r3 = mysqli_query($conn,$q3);
    $row3 = mysqli_fetch_assoc($r3);

    if ($row2['meter_type'] == "House-hold") {
        $min_balance = 50;
    }
    elseif ($row2['meter_type'] == "Commerical") {
        $min_balance = 100;
    }
    else {
        $min_balance = 200;
    }

    $energy_charge = max(0, $row3['amount'] - $min_balance);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Electricity Bill</title>
    <link rel="stylesheet" href="bill.css">
</head>
<body>

<div class="bill-container">

    <div class="bill-header">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>Electricity Department</h2>
        <p>Electricity Consumption Bill</p>
    </div>

    <div class="bill-info">
        <div>
            <p><strong>Name : </strong> <?php echo ucwords(strtolower(trim($row1['name']))); ?></p>
            <p><strong>Address : </strong> <?php echo $row1['address']; ?></p>
            <p><strong>Pincode : </strong> <?php echo $row1['pincode']; ?></p>
            <p><strong>Email : </strong> <?php echo $row1['email']; ?></p>
        </div>

        <div>
            <p><strong>Meter Number : </strong> <?php echo $row2['meter_number']; ?></p>
            <p><strong>Meter Type : </strong> <?php echo $row2['meter_type']; ?></p>
            <p><strong>Bill ID : </strong> <?php echo $bill_id; ?></p>
            <p><strong>Bill Date : </strong> <?php echo $row3['bill_date']; ?></p>
            <p><strong>Due Date : </strong> <?php echo $row3['due_date']; ?></p>
        </div>
    </div>

    <table class="reading-table">
        <tr>
            <th>Description</th>
            <th>Reading</th>
        </tr>
        <tr>
            <td>Previous Reading</td>
            <td><?php echo $prev_read; ?></td>
        </tr>
        <tr>
            <td>Current Reading</td>
            <td><?php echo $cur_read; ?></td>
        </tr>
        <tr>
            <td>Units Consumed</td>
            <td><?php echo $row3['units']; ?></td>
        </tr>
    </table>

    <table class="amount-table">
        <tr>
            <th>Description</th>
            <th>Amount (₹)</th>
        </tr>
        <tr>
            <td>Energy Charges</td>
            <td>₹ <?php echo number_format($energy_charge, 2); ?></td>
        </tr>
        <tr>
            <td>Minimum Balance</td>
            <td>₹ <?php echo number_format($min_balance, 2); ?></td>
        </tr>
        <tr>
            <th>Total Amount Payable</th>
            <th>₹ <?php echo number_format($row3['amount'], 2); ?></th>
        </tr>
    </table>

    <div class="bill-actions">
        <button onclick="window.print()">Print Bill</button>
        <a href="readings.php">Back</a>
    </div>

</div>

</body>
</html>
