<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit();
}

$db = (new Database())->connect();
$student = new Student($db);

$formData = $_POST;
$errors = [];

// Name: required, min 3 chars, no digits
$name = validate($formData['name'] ?? '');
if (empty($name)) {
    $errors['name'] = 'Name is required';
} elseif (strlen($name) < 3) {
    $errors['name'] = 'Name must be at least 3 characters';
} elseif (preg_match('/[0-9]/', $name)) {
    $errors['name'] = 'Name must not contain digits';
}

// Email: required, valid format, no duplicate
$email = validate($formData['email'] ?? '');
if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!validateEmail($email)) {
    $errors['email'] = 'Invalid email format';
} else {
    $student->email = $email;
    if ($student->emailExists()) {
        $errors['email'] = 'A student with this email already exists';
    }
}

// Course: required
$course = validate($formData['course'] ?? '');
if (empty($course)) {
    $errors['course'] = 'Course is required';
}

// Phone: required, Uganda format (07XXXXXXXX)
$phone = validate($formData['phone'] ?? '');
if (empty($phone)) {
    $errors['phone'] = 'Phone number is required';
} elseif (!preg_match('/^(07)[045678][0-9]{7}$/', $phone)) {
    $errors['phone'] = 'Invalid phone number — must start with 07 and be 10 digits';
}

// Reg number: required, format 2X/U/XXXX or 2X/U/XXXX/PS or 2X/U/XXXX/EVE
$reg = validate($formData['reg'] ?? '');
if (empty($reg)) {
    $errors['reg'] = 'Registration number is required';
} elseif (!preg_match('/^2[0-5]\/U\/\d{4}(\/(?:PS|EVE))?$/', $reg)) {
    $errors['reg'] = 'Invalid reg number — use format 2X/U/XXXX or 2X/U/XXXX/PS or 2X/U/XXXX/EVE';
} else {
    $student->reg_number = $reg;
    if ($student->regExists()) {
        $errors['reg'] = 'A student with this registration number already exists';
    }
}

// If errors, redirect back to form with errors + old input
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $formData;
    header("Location: form.php");
    exit();
}

// Assign all fields and save
$student->name         = $name;
$student->course       = $course;
$student->email        = $email;
$student->phone_contact = $phone;
$student->reg_number   = $reg;

if ($student->create()) {
    $_SESSION['success'] = "Student <strong>" . htmlspecialchars($name) . "</strong> was added successfully.";
} else {
    $_SESSION['error'] = "Something went wrong. Please try again.";
}

header("Location: index.php?view=students");
exit();
