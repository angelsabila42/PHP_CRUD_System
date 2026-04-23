<?php
session_start();

$errors   = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['errors'], $_SESSION['form_data']);

$isEdit   = isset($_GET['edit']) && $_GET['edit'] === 'true';
$editData = $_SESSION['edit_data'] ?? [];
unset($_SESSION['edit_data']);

if ($isEdit && !empty($editData)) {
    $formData = array_merge($formData, $editData);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit Student' : 'Add Student'; ?> — Student Portal</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <div class="container">
        <div class="centered-div">
            <h1><?php echo $isEdit ? 'Edit Student' : 'Add New Student'; ?></h1>

            <form action="<?php echo $isEdit ? 'edit.php' : 'create.php'; ?>" method="POST" novalidate>

                <?php if ($isEdit && isset($formData['id'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($formData['id']); ?>">
                <?php endif; ?>

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>"
                       placeholder="e.g. John Doe">
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['name']); ?></span>
                <?php endif; ?>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                       placeholder="e.g. john@example.com">
                <?php if (isset($errors['email'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['email']); ?></span>
                <?php endif; ?>

                <label for="course">Course:</label>
                <input type="text" id="course" name="course"
                       value="<?php echo htmlspecialchars($formData['course'] ?? ''); ?>"
                       placeholder="e.g. Bachelor of Software Engineering">
                <?php if (isset($errors['course'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['course']); ?></span>
                <?php endif; ?>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone"
                       value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>"
                       placeholder="e.g. 0701234567">
                <?php if (isset($errors['phone'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['phone']); ?></span>
                <?php endif; ?>

                <label for="reg">Registration Number:</label>
                <input type="text" id="reg" name="reg"
                       value="<?php echo htmlspecialchars($formData['reg'] ?? ''); ?>"
                       placeholder="e.g. 22/U/1234 or 22/U/1234/PS">
                <?php if (isset($errors['reg'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['reg']); ?></span>
                <?php endif; ?>

                <div style="margin-top: 15px;">
                    <input type="submit" class="submit-btn"
                           value="<?php echo $isEdit ? 'Update Student' : 'Add Student'; ?>">
                    <a href="index.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
