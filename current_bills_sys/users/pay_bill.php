<?php
include('../connection/connect.php');
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../home/login.php");
    exit();
}

if(!isset($_GET['bill_id']))
{
    echo "<script>alert('Invalid request'); window.location.href='user_bills_data.php';</script>";
    exit();
}

$bill_id = $_GET['bill_id'];

$q_amt = "SELECT b.amount, b.status, b.due_date, m.meter_type
          FROM bill b
          JOIN meter m ON b.meter_id = m.meter_id
          WHERE b.bill_id = '$bill_id'";
$r_amt = mysqli_query($conn, $q_amt);
$row_amt = mysqli_fetch_assoc($r_amt);

$amount     = $row_amt['amount'];
$status     = $row_amt['status'];
$due_date   = $row_amt['due_date'];
$meter_type = $row_amt['meter_type'];

$cur_date = date('Y-m-d');

$fine = 0;

if($cur_date > $due_date)
{
    if($meter_type == "House-hold") {
        $fine = 50;
    }
    elseif($meter_type == "Commerical") {
        $fine = 75;
    }
    else {
        $fine = 100;
    }
}

$final_amount = $amount + $fine;


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if($status == 'paid')
    {
        echo "<script>alert('Bill already paid'); window.location.href='user_bills_data.php';</script>";
        exit();
    }

    $q = "UPDATE bill SET status = 'paid' WHERE bill_id = '$bill_id'";
    $r = mysqli_query($conn, $q);

    if($r)
    {
        echo "<script>
                alert('Payment successful');
                window.location.href = 'user_bills_data.php';
              </script>";
        exit();
    }
    else
    {
        echo "<script>alert('Payment failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Gateway</title>
    <link rel="stylesheet" href="user_bills_data.css">
</head>
<body>

<h1>UNIVERSITY OF HYDERABAD</h1>
<h2>ELECTRIC DEPARTMENT</h2>

<div class="container mid">
    <div class="box">
        <h2>Payment Gateway</h2>
        <hr><br>

        <p>Paying the electricity bill</p>

        <p><strong>Bill ID :</strong> <?php echo $bill_id; ?></p>
        <p><strong>Meter Type :</strong> <?php echo $meter_type; ?></p>
        <p><strong>Due Date :</strong> <?php echo $due_date; ?></p>
        <p><strong>Current Date :</strong> <?php echo $cur_date; ?></p>

        <p><strong>Bill Amount :</strong> ₹ <?php echo number_format($amount, 2); ?></p>

        <?php if($fine > 0) { ?>
            <p style="color:red;">
                <strong>Late Fine :</strong> ₹ <?php echo number_format($fine, 2); ?>
            </p>
        <?php } ?>

        <hr>

        <p><strong>Total Payable :</strong> ₹ <?php echo number_format($final_amount, 2); ?></p>

        <form method="post">
            <button type="submit">
                Pay ₹ <?php echo number_format($final_amount, 2); ?>
            </button>
        </form>

        <br>
        <a href="user_bills_data.php">Cancel</a>
    </div>
</div>

</body>
</html>
