<?php
include('../connection/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../admin/reg_form.css">
</head>
<body>

<header>
    <div class="titles">
        <h1>UNIVERSITY OF HYDERABAD</h1>
        <h2>ELECTRIC DEPARTMENT</h2>
    </div>
    <div class="back-btn">
    <button onclick="window.location.href='../admin/admin_dashboard.php'">Back</button>
    </div>
</header>
<hr>

<div class="mid">
    <h3>Admin Registration</h3>
    <hr><br>

    <form method="post">
        <label>Name :</label>
        <input type="text" name="name" required placeholder="Name" autocomplete="off"><br>

        <label>Email :</label>
        <input type="email" name="email" required placeholder="email"><br>

        <label>Phone :</label>
        <input type="text" name="phone" placeholder="Phone Number"><br>

        <label>Address :</label>
        <input type="text" name="address" placeholder="Address"><br>

        <label>Pincode :</label>
        <input type="text" name="pincode" required placeholder="Pincode"><br>

        <label>Username :</label>
        <input type="text" name="username" required placeholder="Username" autocomplete="off"><br>

        <label>Password :</label>
        <input type="password" name="password" required placeholder="Password" autocomplete="off"><br>

        <button type="submit">Register</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);
    $pincode  = trim($_POST['pincode']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role     = "admin";

    $errors = [];

    if (!preg_match("/^[A-Za-z ]{3,50}$/", $name))
        $errors[] = "Name must contain only letters (3–50 chars)";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Invalid email";

    if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be exactly 10 digits";
    }

    if (!preg_match("/^[0-9]{6}$/", $pincode)) {
        $errors[] = "Pincode must be exactly 6 digits";
    }

    if (strlen($password) < 4 || strlen($password) > 10)
        $errors[] = "Password must be 4–10 characters";

    if (!empty($errors)) {
        echo "<script>alert('".implode("\\n", $errors)."');</script>";
        exit;
    }

    $check = mysqli_query(
        $conn,
        "SELECT 1 FROM supervisor_admin_logins 
         WHERE username='$username' AND role='$role' LIMIT 1"
    );

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Admin already exists');</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $q1 = "INSERT INTO admins (name,email,phone,address,pincode)
           VALUES ('$name','$email','$phone','$address','$pincode')";

    if (!mysqli_query($conn, $q1)) {
        echo "<script>alert('Failed to create admin');</script>";
        exit;
    }

    $q2 = "INSERT INTO supervisor_admin_logins (username,password,role)
           VALUES ('$username','$hashed_password','$role')";

    if (!mysqli_query($conn, $q2)) {
        echo "<script>alert('Failed to create admin login');</script>";
        exit;
    }

    echo "<script>
            alert('Admin account created successfully!');
            window.location.href = '../admin/admin_dashboard.php';
          </script>";
}
?>

</body>
</html>
