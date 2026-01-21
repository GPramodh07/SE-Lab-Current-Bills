<?php 
include('../connection/connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>

<header>
    <div class="titles">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>ELECTRIC DEPARTMENT</h2>
    </div>
    <div class="back-btn">
        <button onclick="window.location.href='../home/start.php'">Back</button>
    </div>
</header>
<hr>

<div class="mid">
    <h3>Login Form</h3>
    <hr><br>

    <form method="post">
        <label>Role :</label>
        <select name="role" required>
            <option value="">--select role--</option>
            <option value="admin">Admin</option>
            <option value="supervisor">Supervisor</option>
            <option value="user">User</option>
        </select><br>

        <label>Username :</label>
        <input type="text" name="username" required autocomplete="off" placeholder="Username"><br>

        <label>Password :</label>
        <input type="password" name="password" required autocomplete="off" placeholder="Password"><br>

        <button type="submit">Submit</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $role = trim($_POST['role']);
    $username = trim($_POST['username']);
    $raw_password = $_POST['password'];

    if ($role == "admin" || $role == "supervisor")
    {
        $q = "SELECT * 
              FROM supervisor_admin_logins 
              WHERE username = '$username' 
                AND role = '$role'
              LIMIT 1";

        $r = mysqli_query($conn, $q);

        if (mysqli_num_rows($r) == 0)
        {
            echo "<script>alert('Username not found for this role!');</script>";
            exit;
        }

        $row = mysqli_fetch_assoc($r);

        if (!password_verify($raw_password, $row['password']))
        {
            echo "<script>alert('Incorrect password!');</script>";
            exit;
        }

        $_SESSION['user_id'] = $row['sa_login_id'];
        $_SESSION['role'] = $role;

        if ($role == "admin")
        {
            echo "<script>
                    window.location.href = '../admin/admin_dashboard.php';
                  </script>";
        }
        else
        {
            echo "<script>
                    window.location.href = '../supervisor/supervisor_dashboard.php';
                  </script>";
        }
    }

    else if ($role == "user")
    {
        $q = "SELECT * 
              FROM login_details 
              WHERE username = '$username' 
                AND role = 'user'
              LIMIT 1";

        $r = mysqli_query($conn, $q);

        if (mysqli_num_rows($r) == 0)
        {
            echo "<script>alert('Username not found!');</script>";
            exit;
        }

        $row = mysqli_fetch_assoc($r);

        if (!password_verify($raw_password, $row['password']))
        {
            echo "<script>alert('Incorrect password!');</script>";
            exit;
        }

        $login_id = $row['login_id'];
        $_SESSION['role'] = "user";

        $q1 = "SELECT * FROM login_details WHERE username = '$username'";
        $r1 = mysqli_query($conn,$q1);

        if($r1)
        {
            $row1 = mysqli_fetch_assoc($r1);

            $user_id = $row1['user_id'];

            $_SESSION['user_id'] = $user_id;
            // echo "user id : ";
            // echo $user_id;
        }

        echo "<script>
                window.location.href = '../users/user_dashboard.php';
              </script>";
    }

    else
    {
        echo "<script>alert('Please select a role');</script>";
        exit;
    }
}
?>

</body>
</html>
