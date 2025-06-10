<?php require_once '../classes/authorization.php' ?>
<?php require_once '../classes/qna.php'; ?>
<?php
use Portfolio\Entities\QnA;
use Portfolio\Authorization;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionId = filter_input(INPUT_POST, 'question_id', FILTER_VALIDATE_INT);
    $answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);

    if (!$questionId) {
        $_SESSION['error'] = "Invalid question ID.";
        header("Location: ../unsuccess.php");
        exit();
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $auth = new Authorization();

    if (!$auth->isAdmin()) {
        $_SESSION['error'] = "Unauthorized action.";
        header("Location: ../unsuccess.php");
        exit();
    }

    $qna = new QnA();
    $result = $qna->submitAnswer($questionId, $answer);

    if ($result) {
        header("Location: ../success.php");
        exit();
    } else {
        $_SESSION['error'] = "Error submitting answer.";
        header("Location: ../unsuccess.php");
        exit();
    }
}
?>