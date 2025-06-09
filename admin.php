<?php require_once './classes/authorization.php' ?>
<?php require_once './classes/qna.php' ?>
<?php
use Portfolio\Authorization;
use Portfolio\Entities\QnA;

$auth = new Authorization();
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$qna = new QnA();
$allQuestions = $qna->getAllQuestionsWithDetails();

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="static/style/style.css">
    <link rel="stylesheet" href="static/style/admin.css">
</head>

<body>
    <?php
    require_once 'components/header.php';
    ?>

    <section class="admin-section container">
        <h2>Admin Panel</h2>

        <div class="user-card">
            <h3>User Information</h3>
            <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Admin:</strong> <?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></p>
            <form action="actions/logout.php" method="POST">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <?php
        if (!$auth->isAdmin()) {
            echo '<p class="alert alert-error">You do not have permission to edit content.</p>';
            exit();
        }
        ?>

        <div class="questions-management">
            <h3>Manage Questions</h3>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="alert alert-error"><?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <?php if (empty($allQuestions)): ?>
                <p>No questions submitted yet.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allQuestions as $item): ?>
                            <tr>
                                <td><?php echo $item['question_id']; ?></td>
                                <td><?php echo $item['question_email']; ?></td>
                                <td><?php echo $item['question_text']; ?></td>
                                <td>
                                    <form action="actions/submit_answer.php" method="POST" class="answer-form">
                                        <input type="hidden" name="question_id"
                                            value="<?php echo $item['question_id']; ?>">
                                        <textarea name="answer" rows="3"
                                            placeholder="Enter answer"><?php echo $item['answer_text'] ?? ''; ?></textarea>
                                        <button type="submit" class="btn btn-primary">Submit Answer</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="actions/delete_question.php" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this question?');">
                                        <input type="hidden" name="question_id"
                                            value="<?php echo $item['question_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>

    <?php
    require_once 'components/footer.php';
    ?>
</body>

</html>