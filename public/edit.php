<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

$db = (new Database())->connect();
$student = new Student($db);

// GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit();
    }

    $student->id = $_GET['id'];
    $data = $student->readOne();
    
    // Redirect to form.php with prefilled data
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

// POST (from form.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $formData = $_SESSION['form_data'] ?? $_POST;
    unset($_SESSION['form_data']);
    
    $student->id = $formData['id'];
    $student->name = validate($formData['name'] ?? '');
    $student->course = validate($formData['course'] ?? '');
    $student->email = validateEmail($formData['email'] ?? '');
    $student->phone_contact = validate($formData['phone'] ?? '');
    $student->reg_number = validate($formData['reg'] ?? '');

    $student->update();

    $_SESSION['success'] = "Updated!";
    header("Location: index.php");
    exit();
}
?>

