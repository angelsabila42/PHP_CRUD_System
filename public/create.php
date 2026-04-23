<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

$db = (new Database())->connect();
$student = new Student($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData = $_POST;

    $errors = [];

    $name = validate($formData['name'] ?? '');
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($name) < 3) {
        $errors['name'] = 'Minimum 3 characters';
    } 

    $email = validate($formData['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!validateEmail($email)) {
        $errors['email'] = 'Invalid email';
    }

    $course = validate($formData['course'] ?? '');
    if (empty($course)) {
        $errors['course'] = 'Course is required';
    }

    $phone = validate($formData['phone'] ?? '');
    if (empty($phone)) {
        $errors['phone'] = 'Phone required';
    } elseif(preg_match('/^(07)[045678][0-9]{7}$/', $phone) === 0) {
        $errors['phone'] = 'Invalid phone number, must start with 07 and 10 digits long';
    }

    $reg = validate($formData['reg'] ?? '');
    if (empty($reg)) {
        $errors['reg'] = 'Reg number required';
    } elseif(preg_match('/^2[0-5]\/U\/\d{4}(\/(PS|EVE))?$/', $reg) === 0) {
        $errors['reg'] = 'Invalid reg number must be in format 2X/U/XXXX or 2X/U/XXXX/PS or 2X/U/XXXX/EVE';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $formData;

        header("Location: form.php");
        exit();
    }

    if($student->exists('email', $email)){
        $errors['email'] = 'Email already exists';
    }

    if($student->exists('reg_number', $reg)){
        $errors['reg'] = 'Registration number already exists';
    }

    if($student->exists('phone_contact', $phone)){
        $errors['phone'] = 'Phone number already exists';
    }

    $student->name = $name;
    $student->course = $course;
    $student->email = $email;
    $student->phone_contact = $phone;
    $student->reg_number = $reg;

    if(!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $formData;

        header("Location: form.php");
        exit();
    }

    $student->create();

    $_SESSION['success'] = "Student added!";
    header("Location: index.php?view=students");
    exit();
}