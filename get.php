<?php
$file_path = 'data.json';
$notes = '[]';

if (file_exists($file_path) && filesize($file_path) > 0) {
    $notes = file_get_contents($file_path);
}

header('Content-Type: application/json; charset=utf-8');
echo $notes;
?>