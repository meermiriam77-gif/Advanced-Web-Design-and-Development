<?php

include "db.php";


$id=$_POST['id'];

$name=$_POST['fullname'];

$email=$_POST['email'];

$department=$_POST['department'];

$salary=$_POST['salary'];



mysqli_query($conn,


"UPDATE employees SET

fullname='$name',

email='$email',

department='$department',

salary='$salary'


WHERE employee_id=$id"


);



header("Location:dashboard.php");


?>