<?php

include "db.php";

?>

<!DOCTYPE html>

<html>

<head>

<title>Library Book Management</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<h1>
Library Book Management System
</h1>


<form action="add.php" method="POST">


<input type="text"
name="title"
placeholder="Book Title"
required>


<input type="text"
name="author"
placeholder="Author"
required>


<input type="text"
name="category"
placeholder="Category"
required>


<button type="submit">
Add Book
</button>


</form>



<h2>Book Records</h2>



<table>


<tr>

<th>ID</th>

<th>Title</th>

<th>Author</th>

<th>Category</th>

<th>Actions</th>

</tr>



<?php


$result=mysqli_query(
$conn,
"SELECT * FROM books"
);



while($row=mysqli_fetch_assoc($result)){


?>


<tr>


<td>
<?= $row['book_id']; ?>
</td>


<td>
<?= $row['title']; ?>
</td>


<td>
<?= $row['author']; ?>
</td>


<td>
<?= $row['category']; ?>
</td>



<td>


<a class="edit"
href="edit.php?id=<?=$row['book_id'];?>">
Edit
</a>



<a class="delete"
href="delete.php?id=<?=$row['book_id'];?>">
Delete
</a>


</td>



</tr>



<?php

}

?>


</table>



</div>


</body>

</html>