<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$db = (new Database())->connect();
$student = new Student($db);

$student->id = $_GET['id'];
$student->delete();

$_SESSION['success'] = "Deleted!";
header("Location: index.php");
exit();