<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "current_bills_sys";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn)
{
    echo "<script>
            alert('Error in connecting to database!!!');
          </script>";
}
?>