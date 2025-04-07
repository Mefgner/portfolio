<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A - Ask a Question</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>

<body>
    <?php
    $pageTitle = "Q&A";
    require_once 'components/header.php';
    ?>

    <section class="qna-section container">
        <h2>Question & Answers</h2>
        <p>Have a question? I'd be happy to answer. Fill out the form below to get in touch.</p>

        <div class="form-container">
            <?php require_once 'components/forms/qna.php'; ?>
        </div>
    </section>

    <?php
    require_once 'components/footer.php';
    ?>
</body>

</html>