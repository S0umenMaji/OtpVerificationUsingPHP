<?php
$servername="localhost";
$username="root";
$password="";
$database="register_otp";
$con = mysqli_connect($servername,$username,$password,$database);
if(mysqli_connect_error()){
    echo '<script>alert("Cannot connect to database");</script>';
    exit();
}
?>