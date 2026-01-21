<?php 
    include('../connection/connect.php');
    session_start();

    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../home/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $q1 = "SELECT name FROM user WHERE user_id = '$user_id'";
    $r1 = mysqli_query($conn,$q1);
    $row1 = mysqli_fetch_assoc($r1);
    $name = $row1['name'];

    $q2 = "SELECT * FROM meter WHERE user_id = '$user_id'";
    $r2 = mysqli_query($conn,$q2);
    $row2 = mysqli_fetch_assoc($r2);
    $meter_id = $row2['meter_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bills</title>
    <link rel="stylesheet" href="user_bills_data.css">
</head>
<body>

<h1>UNIVERSITY OF HYDERABAD</h1>
<h2>ELECTRIC DEPARTMENT</h2>

<div class="container">
    <h3>Hello <?php echo ucwords(strtolower(trim($name))); ?></h3>
    <h2>All Electricity Bills</h2><hr><br>

    <table>
        <tr>
            <th>Bill ID</th>
            <th>Meter ID</th>
            <th>Units</th>
            <th>Amount (₹)</th>
            <th>Bill Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

<?php
    $q2 = "SELECT * FROM bill WHERE meter_id = '$meter_id' ORDER BY bill_id DESC";
    $r2 = mysqli_query($conn,$q2);

    if(mysqli_num_rows($r2) == 0)
    {
        echo "<tr>
                <td colspan='7' class='no-data'>No bills found</td>
              </tr>";
    }
    else
    {
        while($row = mysqli_fetch_assoc($r2))
        {
            echo "<tr>
                    <td>{$row['bill_id']}</td>
                    <td>{$row['meter_id']}</td>
                    <td>{$row['units']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['bill_date']}</td>
                    <td>{$row['due_date']}</td>
                    <td>{$row['status']}</td>";


                    if($row['status'] == 'unpaid')
                    {
                        echo "<td>
                            <button onclick=\"window.location.href='pay_bill.php?bill_id={$row['bill_id']}'\">Pay</button>
                        </td>";
                    }
                    else
                    {
                        echo "<td>DONE</td>";
                    }
            echo "</tr>";

        }
    }
?>
    </table>

    <div class="back">
        <a href="../users/user_dashboard.php">Back</a>
    </div>
</div>

</body>
</html>
