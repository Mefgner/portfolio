<?php require_once '../classes/authorization.php' ?>
<?php
use Portfolio\Authorization;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!$name || strlen($name) < 3) {
        $_SESSION['error'] = "Invalid name. It must be at least 3 characters long.";
        header("Location: ../unsuccess.php");
        exit();
    }

    if (!$password || strlen($password) < 6) {
        $_SESSION['error'] = "Invalid password. It must be at least 6 characters long.";
        header("Location: ../unsuccess.php");
        exit();
    }

    $auth = new Authorization();
    $result = $auth->register($name, $password);
    if ($result) {
        header("Location: ../success.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: ../unsuccess.php");
        exit();
    }
}
?>