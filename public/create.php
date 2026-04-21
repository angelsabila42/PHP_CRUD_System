<?php
session_start();

require_once '../config/database.php';
require_once '../classes/Student.php';
require_once '../helpers/validation.php';

$db = (new Database())->connect();
$student = new Student($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = validate($_POST['name']);
    $course = validate($_POST['course']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $reg = validate($_POST['reg']);

    if (empty($name) || empty($course)) {
        $_SESSION['error'] = "Name & Course required";
        header("Location: form.php");
        exit();
    }

    if (!empty($email) && !validateEmail($email)) {
        $_SESSION['error'] = "Invalid email";
        header("Location: form.php");
        exit();
    }

    $student->name = $name;
    $student->course = $course;
    $student->email = $email;
    $student->phone_contact = $phone;
    $student->reg_number = $reg;

    try {
        $student->create();

        $_SESSION['success'] = "New Student added";
        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Email or Registration Number already exists";
        header("Location: form.php");
        exit();
    }
}
?>

<!-- GET: FORM -->
<?php
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

