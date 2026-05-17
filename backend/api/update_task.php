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

$id = $data['id'] ?? null;

$completed = $data['completed'] ?? false;

if (!$id) {

    echo json_encode([
        'success' => false,
        'message' => 'Task ID is required'
    ]);

    exit;

}

$query = "
    UPDATE tasks
    SET completed = :completed
    WHERE id = :id
";

$stmt = $pdo->prepare($query);

$stmt->execute([
    'completed' => $completed,
    'id' => $id
]);

echo json_encode([
    'success' => true,
    'message' => 'Task updated successfully'
]);