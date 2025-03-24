<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Main</title>
    <link rel="stylesheet" href="static/style/style.css">
</head>
<body>
    <?php
        $pageTitle = "Home";
        require_once 'components/header.php';
    ?>

    <section class="hero-section container">
        <h1>Welcome to My Portfolio</h1>
        <p class="lead">Professional Web Developer & UI/UX Designer</p>
    </section>

    <section class="projects-section container">
        <h2>Featured Projects</h2>
        <div class="projects-grid">
            <article class="project-card">
                <h3>E-Commerce Platform</h3>
                <p>Full-stack development using React & Node.js</p>
            </article>
            
            <article class="project-card">
                <h3>Portfolio Website</h3>
                <p>Responsive design with HTML5 & CSS3</p>
            </article>
        </div>
    </section>

    <?php
        require_once 'components/footer.php';
    ?>
</body>
</html>