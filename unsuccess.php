<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errorMessage = $_SESSION['error'] ?? 'An unknown error occurred.';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>

<body>
    <?php include 'components/header.php'; ?>
    <section class="success-page-section">
        <div class="container">
            <div class="success-message-container">
                <h1>Error</h1>
                <p class="alert alert-error"><?= htmlspecialchars($errorMessage) ?></p>
                <a href="index.php" class="btn btn-primary">Go to Homepage</a>
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'; ?>
</body>

</html>