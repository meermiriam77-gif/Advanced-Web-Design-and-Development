<?php

include "db.php";


if(isset($_POST['save'])){


$name=$_POST['fullname'];

$email=$_POST['email'];

$department=$_POST['department'];

$salary=$_POST['salary'];



mysqli_query($conn,

"INSERT INTO employees

(fullname,email,department,salary)

VALUES

('$name','$email','$department','$salary')"

);



header("Location:dashboard.php");


}


?>


<form method="POST">


<input name="fullname"
placeholder="Full Name"
required>


<input name="email"
type="email"
placeholder="Email"
required>


<input name="department"
placeholder="Department"
required>


<input name="salary"
type="number"
placeholder="Salary"
required>



<button name="save">
Save
</button>


</form>