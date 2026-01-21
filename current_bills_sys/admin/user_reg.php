<?php 
    include('../connection/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
    </header><hr>

    <div class="mid">
        <h3>User Registration Form</h3><hr><br>

        <form method="post">
            <label>Name : </label>
            <input type="text" name="name" required autocomplete="off" placeholder="Name"><br>

            <label>Phone : </label>
            <input type="text" name="phone" placeholder="Phone Number"><br>

            <label>Address : </label>
            <input type="text" name="address" placeholder="Address"><br>

            <label>Pincode : </label>
            <input type="text" name="pincode" placeholder="Pincode" required><br>

            <label>Mail : </label>
            <input type="email" name="email" placeholder="email"><br>

            <label>Meter Type : </label>
            <select name="meter_type">
                <option value="">----select meter type----</option>
                <option value="House-hold">Household</option>
                <option value="Commerical">Commerical</option>
                <option value="Industrial">Industrial</option>
            </select><br>

            <label>Meter Number : </label>
            <input type="text" name="meter_number" required placeholder="Meter Number"><br>

            <label>Username : </label>
            <input type="text" name="username" required autocomplete="off" placeholder="Username"><br>

            <label>Password : </label>
            <input type="password" name="password" required autocomplete="off" placeholder="Password"><br>

            <button type="submit">Submit</button>
        </form>
    </div>

<?php 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $email = $_POST['email'];
    $meter_number = $_POST['meter_number'];
    $username = $_POST['username'];
    $meter_type = $_POST['meter_type'];
    $raw_password = $_POST['password'];
    $role = "user";

    $errors = [];

    
    if (!preg_match("/^[A-Za-z ]{3,32}$/", $name)) {
        $errors[] = "Name must be 3–32 characters and contain only letters";
    }

    
    if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be exactly 10 digits";
    }

    
    if (!preg_match("/^[0-9]{6}$/", $pincode)) {
        $errors[] = "Pincode must be exactly 6 digits";
    }

    
    if (!empty($email) && !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/", $email)) {
        $errors[] = "Invalid email format";
    }

    
    if ($meter_type == "Commerical" && !preg_match("/^CM[0-9]{3}$/", $meter_number)) {
        $errors[] = "Commercial meter number must start with CM (ex: CM101)";
    }
    elseif ($meter_type == "House-hold" && !preg_match("/^HM[0-9]{3}$/", $meter_number)) {
        $errors[] = "Household meter number must start with HM (ex: HM101)";
    }
    elseif ($meter_type == "Industrial" && !preg_match("/^IM[0-9]{3}$/", $meter_number)) {
        $errors[] = "Industrial meter number must start with IM (ex: IM101)";
    }

    
    if (!preg_match("/^.{4,10}$/", $raw_password)) {
        $errors[] = "Password must be between 4 and 10 characters";
    }

    if (!empty($errors)) {
    echo "<script>alert('Error!!! Please check them:\\n\\n".implode("\\n", $errors)."');</script>";
    exit();
    }

    $password = password_hash($raw_password, PASSWORD_DEFAULT);

    $q0 = "SELECT 1 FROM login_details 
           WHERE username='$username' 
           OR user_id IN (SELECT user_id FROM meter WHERE meter_number='$meter_number')
           LIMIT 1";
    $r0 = mysqli_query($conn, $q0);

    if(mysqli_num_rows($r0) > 0)
    {
        echo "<script>alert('Account already exists!');</script>";
    }
    else
    {
        $q1 = "INSERT INTO user (name,phone,address,pincode,email)
               VALUES ('$name','$phone','$address','$pincode','$email')";
        $r1 = mysqli_query($conn, $q1);

        if($r1)
        {
            $user_id = mysqli_insert_id($conn);

            $q3 = "INSERT INTO meter (user_id,meter_number,meter_type)
                   VALUES ('$user_id','$meter_number','$meter_type')";
            mysqli_query($conn, $q3);

            $q4 = "INSERT INTO login_details (user_id,username,password,role)
                   VALUES ('$user_id','$username','$password','$role')";
            mysqli_query($conn, $q4);

            echo "<script>
                    alert('account created sucessfully!!');
                    window.location.href = '../admin/admin_dashboard.php';
                  </script>";
        }
    }
}
?>
</body>
</html>
