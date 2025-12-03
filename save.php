<?php
$json_data = file_get_contents('php://input');
$new_note = json_decode($json_data, true);

if ($new_note === null) {
    http_response_code(400); 
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$file_path = 'data.json';

$existing_data = [];
if (file_exists($file_path) && filesize($file_path) > 0) {
    $existing_data = json_decode(file_get_contents($file_path), true);
}

$existing_data[] = $new_note;

file_put_contents($file_path, json_encode($existing_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'saved_note' => $new_note]);
?>