<?php
require_once 'classes/authorization.php';

use Portfolio\Authorization;

$auth = new Authorization();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Use only name and password for registration as per the Authorization class
        $result = $auth->register($name, $password);
        if ($result === true) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed. Please try again."; // Provide a generic error
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>

<body>
    <?php
    $pageTitle = "Register";
    require_once 'components/header.php';
    ?>

    <section class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="alert alert-error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="actions/register.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </section>

    <?php
    require_once 'components/footer.php';
    ?>
</body>

</html>