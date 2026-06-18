<?php

include("db.php");

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM students WHERE id='$id'"
);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];

    mysqli_query(
        $conn,
        "UPDATE students
         SET name='$name',
             email='$email',
             course='$course',
             phone='$phone'
         WHERE id='$id'"
    );

    header("Location:index.php");
}
?>

<form method="POST">

<input type="text" name="name"
value="<?= $row['name']; ?>">

<input type="email" name="email"
value="<?= $row['email']; ?>">

<input type="text" name="course"
value="<?= $row['course']; ?>">

<input type="text" name="phone"
value="<?= $row['phone']; ?>">

<button name="update">
Update
</button>

</form>