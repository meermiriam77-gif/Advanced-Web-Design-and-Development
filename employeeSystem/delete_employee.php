<?php

include "db.php";


$id=$_GET['id'];


mysqli_query($conn,

"DELETE FROM employees

WHERE employee_id=$id"

);


header("Location:dashboard.php");


?>