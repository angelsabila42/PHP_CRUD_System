<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);
$data = $student->readAll();
?>

<h2>Students</h2>

<?php
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

