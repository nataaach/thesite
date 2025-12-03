<?php
date_default_timezone_set('Europe/Kyiv');

$log_file = __DIR__ . '/data/immediate_log.json';

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    if (file_exists($log_file)) {
        unlink($log_file); 
    }
    echo json_encode(['status' => 'cleared']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $log = [];
    if (file_exists($log_file)) {
        $log = json_decode(file_get_contents($log_file), true);
    }

    $server_time = date('Y-m-d H:i:s.v'); 
    
    $log_entry = [
        'event_data' => $data,
        'server_time' => $server_time
    ];

    $log[] = $log_entry;
    
    file_put_contents($log_file, json_encode($log, JSON_PRETTY_PRINT));
    
    echo json_encode(['status' => 'success', 'saved_at' => $server_time]);
} else {
    echo json_encode(['status' => 'no_data']);
}
?>