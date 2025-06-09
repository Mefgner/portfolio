<?php require_once '../classes/qna.php' ?>

<?php
use Portfolio\Entities\QnA;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);

    if ($email && $question) {
        $qna = new QnA();
        $result = $qna->submitQuestion($email, $question);

        if ($result) {
            header("Location: ../success.php");
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "Error submitting question.";
            header("Location: ../unsuccess.php");
            exit();
        }
    }
}
?>