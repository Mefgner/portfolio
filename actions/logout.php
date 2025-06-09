<?php require_once '../classes/authorization.php' ?>
<?php
use Portfolio\Authorization;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Authorization();
    $auth->logout();
    header("Location: ../success.php");
    exit();
}
?>