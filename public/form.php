<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

// Checks if this is edit mode
$isEdit = isset($_GET['edit']) && $_GET['edit'] === 'true';
$editData = $_SESSION['edit_data'] ?? [];
unset($_SESSION['edit_data']);    
// getting saved form data
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

// Merge edit + form data
if ($isEdit && !empty($editData)) {
    $formData = array_merge($formData, $editData);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>
    <div class="container">
        <div class="centered-div">
            <h1><?php echo $isEdit ? 'Edit Student' : 'Student Management Portal'; ?></h1>

            <form action="<?php echo $isEdit ? 'edit.php' : 'create.php'; ?>" method="POST">
                
                <?php if ($isEdit && isset($formData['id'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($formData['id']); ?>">
                <?php endif; ?>

                <label>Name:</label>
                <input type="text" name="name"
                    value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>"><br>
                     <?php if (!isset($errors['name'])) echo"<br>"; ?>
                <?php if (isset($errors['name'])) echo "<span>{$errors['name']}</span>". "<br> <br>"; ?>

                <label>Email:</label>
                <input type="email" name="email"
                    value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"><br> 
                     <?php if (!isset($errors['email'])) echo " <br>"; ?>
                <?php if (isset($errors['email'])) echo "<span>{$errors['email']}</span>". "<br> <br>"; ?>

                <label>Course:</label>
                <input type="text" name="course"
                    value="<?php echo htmlspecialchars($formData['course'] ?? ''); ?>"><br>
                     <?php if (!isset($errors['course'])) echo  " <br>"; ?>
                <?php if (isset($errors['course'])) echo "<span>{$errors['course']}</span>". "<br> <br>"; ?>

                <label>Phone:</label>
                <input type="text" name="phone"
                    value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>"><br>
                     <?php if (!isset($errors['phone'])) echo  "<br>"; ?>
                <?php if (isset($errors['phone'])) echo "<span>{$errors['phone']}</span>". "<br> <br>"; ?>

                <label>Reg No:</label>
                <input type="text" name="reg"
                    value="<?php echo htmlspecialchars($formData['reg'] ?? ''); ?>"><br>
                     <?php if (!isset($errors['reg'])) echo "<br>"; ?>
                <?php if (isset($errors['reg'])) echo "<span>{$errors['reg']}</span>". "<br> <br>"; ?>

                <input type="submit" value="<?php echo $isEdit ? 'Update' : 'Submit'; ?>">
            </form>
        </div>
    </div>
</body>
</html>