<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
<title>Student Management System</title>
</head>

<body>

<h2>Add Student</h2>

<form action="add.php" method="POST">

<input type="text" name="name" placeholder="Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="course" placeholder="Course" required>

<input type="text" name="phone" placeholder="Phone" required>

<button type="submit">Save</button>

</form>

<hr>

<h2>Students List</h2>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Course</th>
<th>Phone</th>
<th>Actions</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM students");

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?= $row['id']; ?></td>
<td><?= $row['name']; ?></td>
<td><?= $row['email']; ?></td>
<td><?= $row['course']; ?></td>
<td><?= $row['phone']; ?></td>

<td>

<a href="edit.php?id=<?= $row['id']; ?>">Edit</a>

<a href="delete.php?id=<?= $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>