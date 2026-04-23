<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

$db      = (new Database())->connect();
$student = new Student($db);

$showTable          = isset($_GET['view']) && $_GET['view'] === 'students';
$viewWelcomeMessage = !isset($_GET['view']);

// Collect flash messages
$successMsg = $_SESSION['success'] ?? null;
$errorMsg   = $_SESSION['error']   ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Student Management Portal</title>
    <style>
        .flash-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .flash-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .page-wrapper {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <?php if ($successMsg): ?>
        <div class="flash-success"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div class="flash-error"><?php echo htmlspecialchars($errorMsg); ?></div>
    <?php endif; ?>

    <?php if ($viewWelcomeMessage): ?>
        <div class="welcome-div">
            <h1>Welcome to Student Management Portal</h1>
            <div class="menu-options">
                <a href="form.php" class="menu-btn">➕ Add Student</a>
                <a href="index.php?view=students" class="menu-btn">📋 View All Students</a>
                <a href="index.php?view=students" class="menu-btn">✏️ Edit Student Details</a>
                <a href="index.php?view=students" class="menu-btn">🗑️ Delete a Student</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($showTable): ?>
        <h2>Student Records</h2>
        <a href="form.php" class="back-btn" style="margin-bottom:15px; display:inline-block;">➕ Add New Student</a>

        <?php $data = $student->readAll(); ?>

        <?php if ($data->rowCount() === 0): ?>
            <p>No student records found. <a href="form.php">Add the first student</a>.</p>
        <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Phone</th>
                    <th>Reg Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone_contact']); ?></td>
                    <td><?php echo htmlspecialchars($row['reg_number']); ?></td>
                    <td>
                        <div class="container">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn"
                               onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($row['name'])); ?>?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <br>
        <a href="index.php" class="back-btn">← Back to Menu</a>
    <?php endif; ?>

</div>
</body>
</html>
