<?php
$data = array(
    'title' => $config['title'],
    'description' => $config['description'],
    'version' => $config['version'],
    'author' => $config['author'],
    'used endpoint' => $endpoint,
    'endpoints/actions' => $config['endpoints'],
    'status' => $config['status']['200'],
);
header('Content-Type: application/json');
echo json_encode($data);
?>