<?php require_once 'classes/qna.php' ?>

<?php
use Portfolio\Entities\QnA;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $qna = new QnA();
    $answeredQuestions = $qna->getAnsweredQuestions();

    if (is_string($answeredQuestions)) {
        echo $answeredQuestions;
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <?php if (!empty($answeredQuestions)): ?>
        <div class="answered-questions">
            <h3 class="answered-questions-title">Answered Questions</h3>
            <?php foreach ($answeredQuestions as $qa): ?>
                <div class="qa-item">
                    <h4 class="question"><?php echo $qa['question']; ?></h4>
                    <p class="answer"><?php echo $qa['answer']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No answered questions yet.</p>
    <?php endif; ?>
</body>

</html>