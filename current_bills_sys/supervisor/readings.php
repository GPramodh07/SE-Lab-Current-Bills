<?php 
    include('../connection/connect.php');
    session_start();

    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../home/login.php");
        exit();
    }


    function calc_household($units)
    {
        $amount = 0;
        $remaining = $units;

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 1.5;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 2;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 2.5;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $amount += $remaining * 3;
        }

        return $amount;
    }

    function calc_commerical($units)
    {
        $amount = 0;
        $remaining = $units;

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 2;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 2.5;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 3;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $amount += $remaining * 4;
        }

        return $amount;
    }

    function calc_industrial($units)
    {
        $amount = 0;
        $remaining = $units;

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 2;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 3;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $use = min(50, $remaining);
            $amount += $use * 4;
            $remaining -= $use;
        }

        if($remaining > 0) {
            $amount += $remaining * 5;
        }

        return $amount;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Readings</title>
    <link rel="stylesheet" href="read.css">
</head>
<body>

<header>
    <div class="titles">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>ELECTRIC DEPARTMENT</h2>
    </div>

    <div class="buttons">
        <button onclick="window.location.href='../supervisor/supervisor_dashboard.php'">Back</button>
    </div>
</header>
<hr>

<div class="mid">
    <h2>Meter Readings</h2><hr><br>

    <form method="post">
        <label>Meter Type : </label>
        <select name="meter_type" required>
            <option value="">----select meter type----</option>
            <option value="House-hold">Household</option>
            <option value="Commerical">Commerical</option>
            <option value="Industrial">Industrial</option>
        </select><br>

        <label>Meter Number : </label>
        <input type="text" name="meter_number" required placeholder="Meter Number"><br>

        <label>Date : </label>
        <input type="date" name="x_date" required><br>

        <label>Reading : </label>
        <input type="number" name="x_read" required placeholder="Reading"><br>

        <label>Due Date : </label>
        <input type="date" name="x_due_date" required><br>

        <button type="submit">Generate Bill</button>
    </form>
</div>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $meter_type   = $_POST['meter_type'];
    $meter_number = $_POST['meter_number'];
    $cur_date     = $_POST['x_date'];
    $cur_read     = $_POST['x_read'];
    $due_date     = $_POST['x_due_date'];

    $q_check = "SELECT meter_id, meter_type FROM meter WHERE meter_number = '$meter_number'";
    $r_check = mysqli_query($conn, $q_check);

    if(mysqli_num_rows($r_check) == 0)
    {
        echo "<script>alert('Meter number not found');</script>";
        exit();
    }

    $row_check = mysqli_fetch_assoc($r_check);
    $db_meter_type = $row_check['meter_type'];
    $meter_id = $row_check['meter_id'];

    if($meter_type !== $db_meter_type)
    {
        echo "<script>alert('Selected meter type does not match meter record');</script>";
        exit();
    }

    $q1 = "SELECT cur_read FROM meter_reading
           WHERE meter_id = '$meter_id'
           ORDER BY reading_id DESC
           LIMIT 1";
    $r1 = mysqli_query($conn,$q1);

    if(mysqli_num_rows($r1) > 0)
    {
        $row1 = mysqli_fetch_assoc($r1);
        $prev_read = $row1['cur_read'];
    }
    else
    {
        $prev_read = 0;
    }

    $units = $cur_read - $prev_read;

    if($units < 0)
    {
        echo "<script>alert('Invalid meter reading');</script>";
        exit();
    }

    if($units == 0)
    {
        if($meter_type == "House-hold") {
            $amount = 50;
        }
        elseif($meter_type == "Commerical") {
            $amount = 100;
        }
        else {
            $amount = 200;
        }
    }
    else
    {
        if($meter_type == "House-hold") {
            $amount = calc_household($units) + 50;
        }
        elseif($meter_type == "Commerical") {
            $amount = calc_commerical($units) + 100;
        }
        else {
            $amount = calc_industrial($units) + 200;
        }
    }


    $q2 = "INSERT INTO meter_reading
           (meter_id, prev_date, prev_read, due_date, cur_read)
           VALUES
           ('$meter_id','$cur_date','$prev_read','$due_date','$cur_read')";
    $r2 = mysqli_query($conn,$q2);

    if($r2)
    {

        $q3 = "INSERT INTO bill
               (meter_id, units, amount, bill_date, due_date)
               VALUES
               ('$meter_id','$units','$amount','$cur_date','$due_date')";
        $r3 = mysqli_query($conn,$q3);

        $q = "SELECT bill_id FROM bill
              WHERE meter_id = '$meter_id'
              ORDER BY bill_id DESC
              LIMIT 1";
        $r = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($r);
        $bill_id = $row['bill_id'];

        $q5 = "SELECT user_id FROM meter WHERE meter_id = '$meter_id'";
        $r5 = mysqli_query($conn,$q5);
        $row = mysqli_fetch_assoc($r5);
        $user_id = $row['user_id'];

        $_SESSION['meter_id'] = $meter_id;
        $_SESSION['bill_id'] = $bill_id;
        $_SESSION['act_user_id'] = $user_id;
        $_SESSION['prev_read'] = $prev_read;
        $_SESSION['cur_read'] = $cur_read;

        echo "<script>
            alert('Bill generated successfully');
            window.location.href = '../supervisor/bill.php';
        </script>";
    }
}
?>

</body>
</html>
