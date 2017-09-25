<?php
$data = array(
    'title' => $config['title'],
    'description' => $config['description'],
    'id required' => $config['require_id'],
    'version' => $config['version'],
    'author' => $config['author'],
    'used endpoint' => $endpoint,
    'status' => $config['status']['200'],
);
header('Content-Type: application/json');
echo json_encode($data);
?>