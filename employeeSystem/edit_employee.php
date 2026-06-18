<?php

include "db.php";


$id=$_GET['id'];


$result=mysqli_query(
$conn,
"SELECT * FROM employees 
WHERE employee_id=$id"
);


$row=mysqli_fetch_assoc($result);


?>


<form action="update_employee.php"
method="POST">


<input type="hidden"
name="id"
value="<?=$row['employee_id']?>">


<input name="fullname"
value="<?=$row['fullname']?>">


<input name="email"
value="<?=$row['email']?>">


<input name="department"
value="<?=$row['department']?>">


<input name="salary"
value="<?=$row['salary']?>">


<button>
Update
</button>


</form>