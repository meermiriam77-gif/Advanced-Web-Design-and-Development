<?php

session_start();

include "db.php";


if(!isset($_SESSION['username'])){

header("Location:login.php");

}


$search="";


if(isset($_GET['search'])){

$search=$_GET['search'];

}



$result=mysqli_query(
$conn,

"SELECT * FROM employees

WHERE fullname LIKE '%$search%'"

);


?>


<!DOCTYPE html>

<html>

<head>

<title>Employee Records</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<h1>
Employee Management System
</h1>


<a href="add_employee.php">
Add Employee
</a>


<a href="logout.php">
Logout
</a>



<form>

<input type="text"
name="search"
placeholder="Search employee">


<button>
Search
</button>

</form>



<table>


<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Department</th>

<th>Salary</th>

<th>Action</th>

</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td><?=$row['employee_id']?></td>

<td><?=$row['fullname']?></td>

<td><?=$row['email']?></td>

<td><?=$row['department']?></td>

<td><?=$row['salary']?></td>


<td>

<a href="edit_employee.php?id=<?=$row['employee_id']?>">
Edit
</a>


<a href="delete_employee.php?id=<?=$row['employee_id']?>">
Delete
</a>


</td>


</tr>


<?php } ?>


</table>



</div>


</body>

</html>