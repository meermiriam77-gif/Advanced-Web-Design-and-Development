<?php

include "db.php";


$id=$_GET['id'];



$result=mysqli_query(
$conn,
"SELECT * FROM books WHERE book_id=$id"
);


$row=mysqli_fetch_assoc($result);



?>


<!DOCTYPE html>

<html>

<head>

<title>Edit Book</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<h1>Edit Book</h1>



<form action="update.php" method="POST">



<input type="hidden"
name="book_id"
value="<?=$row['book_id']?>">



<input type="text"
name="title"
value="<?=$row['title']?>">



<input type="text"
name="author"
value="<?=$row['author']?>">



<input type="text"
name="category"
value="<?=$row['category']?>">



<button>
Update Book
</button>


</form>



</div>


</body>

</html>