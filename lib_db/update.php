<?php

include "db.php";


$id=$_POST['book_id'];

$title=$_POST['title'];

$author=$_POST['author'];

$category=$_POST['category'];



$sql="UPDATE books SET

title='$title',

author='$author',

category='$category'


WHERE book_id=$id";



mysqli_query($conn,$sql);



header("Location:index.php");


?>