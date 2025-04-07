<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);

    if ($email && $question) {
        try {
            $db = new mysqli("localhost", "root", "", "portfolio");

            if ($db->connect_error) {
                echo "<div class='alert alert-error'>Connection failed to db with error code: " . $db->connect_error . "</div>";
            } else {
                $stmt = $db->prepare("INSERT INTO questions (email, question) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $question);
                $stmt->execute();
                $stmt->close();
                $db->close();
                echo "<div class='alert alert-success'>Your question was uploaded successfully</div>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "<div class='alert alert-error'>" . $e->getMessage() . "</div>";
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    try {
        $db = new mysqli("localhost", "root", "", "portfolio");

        if ($db->connect_error) {
            echo "<div class='alert alert-error'>Connection failed to db with error code: " . $db->connect_error . "</div>";
        } else {
            $stmt = $db->prepare("SELECT answer, questions.question FROM answered_questions JOIN questions ON answered_questions.question_id = questions.id");
            $stmt->execute();
            $result = $stmt->get_result();
            $answeredQuestions = [];

            while ($row = $result->fetch_assoc()) {
                $answeredQuestions[] = $row;
            }

            $stmt->close();
            $db->close();
        }
    } catch (mysqli_sql_exception $e) {
        echo "<div class='alert alert-error'>" . $e->getMessage() . "</div>";
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
    <?php if (!empty($answeredQuestions)): ?>
        <div class="answered-questions">
            <h3 class="answered-questions-title">Answered Questions</h3>
            <?php foreach ($answeredQuestions as $qa): ?>
                <div class="qa-item">
                    <h4 class="question"><?php echo htmlspecialchars($qa['question']); ?></h4>
                    <p class="answer"><?php echo htmlspecialchars($qa['answer']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No answered questions yet.</p>
    <?php endif; ?>

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