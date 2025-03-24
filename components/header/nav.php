<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <nav class="main-nav">
        <div class="container">
            <ul>
                <?php
                $file = file_get_contents("components/header/nav-links.json");
                $json = json_decode($file, true);
                foreach ($json as $item) {
                    $isSet = basename($_SERVER['PHP_SELF']) === $item['link'] ? 'active' : '';
                    echo "<li><a href=\"$item[link]\" class=\"$isSet\">$item[text]</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
</body>
</html>