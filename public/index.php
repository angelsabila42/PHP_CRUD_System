<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);
$data = $student->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Document</title>
</head>
<body>
    <h2>Students</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Phone Number</th>
        <th>Registration Number</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($data as $row) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['course']; ?></td>
        <td><?php echo $row['phone_contact']; ?></td>
        <td><?php echo $row['reg_number']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a> |
            <a href="delete.php?id=<?php echo $row['id']; ?>" class = "delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
        
        </td>
    </tr>
    <?php } ?>
</body>

<?php
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
</html>



