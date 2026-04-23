<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);

// Fetch all student records from the database | by Mugarura Albert
$data = $student->readAll();

// Determine which view to show based on URL parameter | by Mugarura Albert
$showTable = isset($_GET['view']) && $_GET['view'] === 'students';
$viewWelcomeMessage = !isset($_GET['view']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Student Management</title>
</head>
<body>

    <!-- Welcome menu shown on first load | by Mugarura Albert -->
    <?php if ($viewWelcomeMessage): ?>
        <div class="welcome-div">
            <h1>Welcome to the Student Management Portal</h1>
            <div class="menu-options">
                <a href="form.php" class="menu-btn">1. Add Student</a>
                <a href="index.php?view=students" class="menu-btn">2. View Existing Students</a>
                <a href="index.php?view=students#edit-section" class="menu-btn">3. Edit Student Details</a>
                <a href="index.php?view=students#delete-section" class="menu-btn">4. Delete a Student</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Student records table shown when ?view=students | by Mugarura Albert -->
    <?php if ($showTable): ?>
        <h2 id="edit-section">Student List</h2>

        <!-- Display flash success message after adding a student | by Mugarura Albert -->
        <?php if (isset($_SESSION['success'])): ?>
            <span class="success-message">
                <?php
                    // Sanitize output to prevent XSS attacks | by Mugarura Albert
                    echo htmlspecialchars($_SESSION['success']);
                    unset($_SESSION['success']);
                ?>
            </span>
        <?php endif; ?>

        <!-- Table displaying all student records fetched from the database | by Mugarura Albert -->
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

            <!-- Loop through each student record and render a table row | by Mugarura Albert -->
            <?php foreach ($data as $row): ?>
            <tr>
                <!-- htmlspecialchars() used on all output to prevent XSS | by Mugarura Albert -->
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td><?php echo htmlspecialchars($row['phone_contact']); ?></td>
                <td><?php echo htmlspecialchars($row['reg_number']); ?></td>
                <td>
                    <div class="container">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a> |
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn"
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table><br>

        <!-- Back button to return to the main menu | by Mugarura Albert -->
        <a href="index.php" class="back-btn">Back to Menu</a>
    <?php endif; ?>

</body>
</html>
