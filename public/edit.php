<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

$db = (new Database())->connect();
$student = new Student($db);

// GET → load data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit();
    }

    $student->id = $_GET['id'];
    $data = $student->readOne();

    $_SESSION['edit_data'] = [
        'id' => $data['id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'course' => $data['course'],
        'phone' => $data['phone_contact'],
        'reg' => $data['reg_number']
    ];

    header("Location: form.php?edit=true");
    exit();
}

// POST → validate + update
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
    }

    $reg = validate($formData['reg'] ?? '');
    if (empty($reg)) {
        $errors['reg'] = 'Reg number required';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $formData;

        header("Location: form.php?edit=true");
        exit();
    }

    $student->id = $formData['id'];
    $student->name = $name;
    $student->course = $course;
    $student->email = $email;
    $student->phone_contact = $phone;
    $student->reg_number = $reg;

    $student->update();

    $_SESSION['success'] = "Updated successfully";
    header("Location: index.php");
    exit();
}