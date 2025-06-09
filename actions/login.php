<?php require_once '../classes/authorization.php' ?>
<?php
use Portfolio\Authorization;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $auth = new Authorization();
    $result = $auth->login($name, $password);
    if ($result) {
        header("Location: ../success.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid login or password. Please try again.";
        
    }
}
?>