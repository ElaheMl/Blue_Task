<?php

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$title = trim($data['title'] ?? '');

if ($title === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Title is required'
    ]);

    exit;
}

$query = "INSERT INTO tasks (title) VALUES (:title)";

$stmt = $pdo->prepare($query);

$stmt->execute([
    'title' => $title
]);

echo json_encode([
    'success' => true,
    'message' => 'Task created successfully'
]);