<?php
require_once 'classes/authorization.php';

use Portfolio\Authorization;

$auth = new Authorization();

if ($auth->isLoggedIn()) {
    if ($auth->isAdmin()) {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

// Error message handling will be done by actions/login.php via session
// So, no need to handle $error here directly from POST

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>

<body>
    <?php
    require_once 'components/header.php';
    ?>

    <section class="container">
        <h2>Login</h2>
        <?php
        if (isset($_SESSION['error'])): ?>
            <p class="alert alert-error"><?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p class="alert alert-success"><?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <form action="actions/login.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </section>

    <?php
    require_once 'components/footer.php';
    ?>
</body>

</html>