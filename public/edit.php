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
}

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student->id = $_POST['id'];
    $student->name = validate($_POST['name']);
    $student->course = validate($_POST['course']);
    $student->email = validate($_POST['email']);
    $student->phone_contact = validate($_POST['phone_contact']);
    $student->reg_number = validate($_POST['reg_number']);

    $student->update();

    $_SESSION['success'] = "Updated!";
    header("Location: index.php");
    exit();
}
?>

