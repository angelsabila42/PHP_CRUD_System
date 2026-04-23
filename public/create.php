<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

$db = (new Database())->connect();
$student = new Student($db);

// Only allow POST requests — redirect to form if accessed directly | by Mugarura Albert
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit();
}

// Collect submitted form data | by Mugarura Albert
$formData = $_POST;
$errors = [];

// Validate name: required, min 3 chars, no digits | by Mugarura Albert
$name = validate($formData['name'] ?? '');
if (empty($name)) {
    $errors['name'] = 'Name is required';
} elseif (strlen($name) < 3) {
    $errors['name'] = 'Minimum 3 characters';
} elseif (preg_match('/[0-9]/', $name)) {
    // Added digit check to prevent numbers in names | by Mugarura Albert
    $errors['name'] = 'Name must not contain digits';
}

// Validate email: required and must be valid format | by Mugarura Albert
$email = validate($formData['email'] ?? '');
if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!validateEmail($email)) {
    $errors['email'] = 'Invalid email';
}

// Validate course: required | by Mugarura Albert
$course = validate($formData['course'] ?? '');
if (empty($course)) {
    $errors['course'] = 'Course is required';
}

// Validate phone: required and must match Uganda format 07XXXXXXXX | by Mugarura Albert
$phone = validate($formData['phone'] ?? '');
if (empty($phone)) {
    $errors['phone'] = 'Phone required';
} elseif (preg_match('/^(07)[045678][0-9]{7}$/', $phone) === 0) {
    $errors['phone'] = 'Invalid phone number, must start with 07 and 10 digits long';
}

// Validate reg number: required and must match university format | by Mugarura Albert
$reg = validate($formData['reg'] ?? '');
if (empty($reg)) {
    $errors['reg'] = 'Reg number required';
} elseif (preg_match('/^2[0-5]\/U\/\d{4}(\/(PS|EVE))?$/', $reg) === 0) {
    $errors['reg'] = 'Invalid reg number must be in format 2X/U/XXXX or 2X/U/XXXX/PS or 2X/U/XXXX/EVE';
}

// Duplication Checks — prevent same email, reg number or phone being registered twice | by Mugarura Albert
if ($student->exists('email', $email)) {
    $errors['email'] = 'Email already exists';
}

if ($student->exists('reg_number', $reg)) {
    $errors['reg'] = 'Registration number already exists';
}

if ($student->exists('phone_contact', $phone)) {
    $errors['phone'] = 'Phone number already exists';
}

// If there are errors, save them in session and redirect back to form (PRG pattern) | by Mugarura Albert
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $formData; // Preserve old input so user doesn't retype | by Mugarura Albert
    header("Location: form.php");
    exit();
}

// Assign validated data to student object | by Mugarura Albert
$student->name          = $name;
$student->course        = $course;
$student->email         = $email;
$student->phone_contact = $phone;
$student->reg_number    = $reg;

// Save student to database using PDO prepared statement | by Mugarura Albert
$student->create();

// Flash success message and redirect to student list | by Mugarura Albert
$_SESSION['success'] = "Student added!";
header("Location: index.php?view=students");
exit();
