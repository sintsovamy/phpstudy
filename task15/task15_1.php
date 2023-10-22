<?php
$dirs = scandir(__DIR__ . '/');
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo $dir . '<br>';
    }
}
