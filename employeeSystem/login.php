<?php

session_start();

include "db.php";


if(isset($_POST['login'])){


$username=$_POST['username'];

$password=$_POST['password'];



$result=mysqli_query(
$conn,
"SELECT * FROM users 
WHERE username='$username'"
);



$user=mysqli_fetch_assoc($result);



if($user && password_verify(
$password,
$user['password']
)){


$_SESSION['username']=$username;


header("Location:dashboard.php");


}

else{


echo "Invalid Login";


}


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


<button name="login">
Login
</button>


</form>