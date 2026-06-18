<?php

include("db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];
$phone = $_POST['phone'];

$sql = "INSERT INTO students(name,email,course,phone)
VALUES('$name','$email','$course','$phone')";

mysqli_query($conn,$sql);

header("Location:index.php");

?>