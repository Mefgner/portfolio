<?php
function renderFromFile($filePath, $navClass)
{
    $file = file_get_contents($filePath);
    $json = json_decode($file, true);
    echo "<ul class=\"$navClass\">";
    foreach ($json as $item) {
        $isSet = basename($_SERVER['PHP_SELF']) === $item['link'] ? 'active' : '';
        echo "<li><a href=\"$item[link]\" class=\"$isSet\">$item[text]</a></li>";
    }
    echo "</ul>";
}
?>