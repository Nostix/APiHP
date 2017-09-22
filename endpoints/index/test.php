<?php
$data = array(
    'test' => 'passed',
    'version' => $config['version'],
    'author' => $config['author'],
    'status' => $config['status']['200'],
);
header('Content-Type: application/json');
echo json_encode($data);
?>