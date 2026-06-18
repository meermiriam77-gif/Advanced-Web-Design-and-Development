<?php

include "db.php";


if(isset($_POST['register'])){


$username=$_POST['username'];

$password=password_hash(
$_POST['password'],
PASSWORD_DEFAULT
);



$sql="INSERT INTO users(username,password)

VALUES('$username','$password')";



mysqli_query($conn,$sql);



echo "User registered successfully";


}

?>


<form method="POST">


<input type="text" 
name="username"
placeholder="Username"
required>


<input type="password"
name="password"
placeholder="Password"
required>


<button name="register">
Register
</button>


</form>