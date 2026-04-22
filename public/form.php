<?php
session_start();
$errors = [];

// Check if this is edit mode
$isEdit = isset($_GET['edit']) && $_GET['edit'] === 'true';
$editData = $_SESSION['edit_data'] ?? [];
unset($_SESSION['edit_data']);

//getting form savd data
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

// Merging
if ($isEdit && !empty($editData)) {
    $formData = array_merge($formData, $editData);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../helpers/validation.php';
    
    // Validate Name
    $name = validate($_POST['name'] ?? '');
    if (empty($name)) {
        $errors['name'] = 'Name is required va mmalala';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters';
    }
    
    // Validate Email
    $email = validate($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!validateEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Validate Course
    $course = validate($_POST['course'] ?? '');
    if (empty($course)) {
        $errors['course'] = 'Course is required';
    }
    
    // Validate Phone
    $phone = validate($_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors['phone'] = 'Phone must be 10-15 digits';
    }
    
    // Validate Registration Number
    $reg = validate($_POST['reg'] ?? '');
    if (empty($reg)) {
        $errors['reg'] = 'Registration number is required';
    }
    
    // If no errors, redirect to create.php or edit.php with data in session
    if (empty($errors)) {
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email,
            'course' => $course,
            'phone' => $phone,
            'reg' => $reg
        ];
        
        if ($isEdit && isset($_POST['id'])) {
            $_SESSION['form_data']['id'] = $_POST['id'];
            header('Location: edit.php');
        } else {
            header('Location: create.php');
        }
        exit;
    }
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
            <form action="<?php echo $isEdit ? 'edit.php' : 'create.php'; ?>" method = "POST">
                <?php if ($isEdit && isset($formData['id'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($formData['id']); ?>">
                <?php endif; ?>
    
                <label for = "name">Name: </label> 
                <input type = "text" name = "name" id = "name" value="<?php echo htmlspecialchars($_POST['name'] ?? $formData['name'] ?? ''); ?>" required minlength="3"><br><br>
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?php echo $errors['name']; ?></span><br>
                <?php endif; ?>
                
                <label for = "email">Email: </label> 
                <input type = "email" name = "email" id = "email" value="<?php echo htmlspecialchars($_POST['email'] ?? $formData['email'] ?? ''); ?>" required><br><br>
                <?php if (isset($errors['email'])): ?>
                    <span class="error"><?php echo $errors['email']; ?></span><br>
                <?php endif; ?>
                
                <label for = "course">Course: </label> 
                <input type = "text" name = "course" id = "course" value="<?php echo htmlspecialchars($_POST['course'] ?? $formData['course'] ?? ''); ?>" required><br><br>
                <?php if (isset($errors['course'])): ?>
                    <span class="error"><?php echo $errors['course']; ?></span><br>
                <?php endif; ?>
                
                <label for = "phone">Phone Number: </label> 
                <input type = "tel" name = "phone" id = "phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? $formData['phone'] ?? ''); ?>" required pattern="[0-9]{10,15}" title="10-15 digits"><br><br>
                <?php if (isset($errors['phone'])): ?>
                    <span class="error"><?php echo $errors['phone']; ?></span><br>
                <?php endif; ?>
                
                <label for ="reg">Registration Number: </label> 
                <input type="text" name = "reg" id = "reg" value="<?php echo htmlspecialchars($_POST['reg'] ?? $formData['reg'] ?? ''); ?>" required><br><br>
                <?php if (isset($errors['reg'])): ?>
                    <span class="error"><?php echo $errors['reg']; ?></span><br>
                <?php endif; ?>

                <input type="submit" class="submit-btn" value="<?php echo $isEdit ? 'Update' : 'Submit'; ?>">
                <?php if ($isEdit): ?>
                    <a href="index.php" class="cancel-btn">Cancel</a> <br>
                <?php endif; ?>
            </form>
            
            <div class="back-link"> <br>
                <a href="index.php?view=students" class="back-btn">Back to Student List</a>
            </div>
        </div>
    </div>
</body>
</html>