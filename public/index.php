<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);
$data = $student->readAll();

// Check if table should be shown
$showTable = isset($_GET['view']) && $_GET['view'] === 'students';
$viewWelcomeMessage = !isset($_GET['view']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Student Management <Portal></Portal></title>
</head>
<body>
     <?php if ($viewWelcomeMessage): ?>
        <div class="welcome-div">
        <h1>Welcome to Student Management Portal</h1>
        <div class="menu-options">
            <a href="form.php" class="menu-btn">1. Add Student</a> <br>
            <a href="index.php?view=students" class="menu-btn">2. View Existing Students</a> <br>
            <a href="index.php?view=students#edit-section" class="menu-btn">3. Edit Student Details</a> <br>
            <a href="index.php?view=students#delete-section" class="menu-btn">4. Delete a Student</a> <br> <br>
        </div>
    </div>
    <?php endif; ?>
    
        
        
    

    <?php if ($showTable): ?>
    <h2 id="edit-section">Student List</h2>
   
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Phone Number</th>
        <th>Registration Number</th>
        <th id="delete-section">Actions</th>
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
            <div class = "container">
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>" class = "delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
            </div>

        </td>
    </tr>
    <?php } ?>
</table> <br>
 <a href="index.php" class="back-btn">Back to Menu</a>
    <?php endif; ?>
</body>

<?php
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
</html>



