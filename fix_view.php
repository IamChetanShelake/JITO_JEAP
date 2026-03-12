<?php
$content = file_get_contents('resources/views/website/home.blade.php');
// Fix line 343 - remove semicolon after }} in Blade expression
$replace = "E31E25'))) }} box-shadow";
$content = str_replace($search, $replace, $content);
file_put_contents('resources/views/website/home.blade.php', $content);
echo "Done";
