<?php require_once 'classes/qna.php' ?>

<?php
use Portfolio\QnA;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);

    if ($email && $question) {
        $qna = new QnA('portfolio');
        $result = $qna->submitQuestion($email, $question);

        if (is_string($result)) {
            echo $result;
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Question</title>
</head>

<body>
    <form method="POST" action="" class="qna-form">
        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required class="form-control">
        </div>

        <div class="form-group">
            <label for="question">Your Question:</label>
            <textarea id="question" name="question" rows="4" required class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Question</button>
    </form>
</body>

</html>