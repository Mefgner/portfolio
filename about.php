<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>
<body>
    <?php
        $pageTitle = "About Me";
        require_once 'components/header.php';
    ?>

    <section class="about-section container">
        <h2>About Me</h2>
        <div class="about-content">
            <img src="static/img/profile.jpg" alt="Profile Picture" class="profile-img">
            <div class="bio">
                <p>Full-stack developer with 99 years of experience building web applications. Specialized in:</p>
                <ul class="skills-list">
                    <li>PHP</li>
                    <li>JavaScript (React & Vue)</li>
                    <li>Database Design (MySQL)</li>
                    <li>REST API Development (ExpressJs)</li>
                </ul>
            </div>
        </div>
    </section>

    <?php
        require_once 'components/footer.php';
    ?>
</body>
</html>