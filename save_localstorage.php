<?php
$log_file = __DIR__ . '/data/localstorage_log.json';

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    if (file_exists($log_file)) {
        unlink($log_file);
    }
    echo json_encode(['status' => 'cleared']);
    exit;
}

$data_blob = file_get_contents('php://input');

if ($data_blob) {
    file_put_contents($log_file, $data_blob);
    
    echo json_encode(['status' => 'success', 'message' => 'Batch log saved.']);
} else {
    echo json_encode(['status' => 'no_data']);
}
?>