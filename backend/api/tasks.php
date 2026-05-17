<?php

header("Access-Control-Allow-Origin: *");

header('Content-Type: application/json');

require_once '../config/database.php';

$query = "SELECT * FROM tasks ORDER BY created_at DESC";

$stmt = $pdo->query($query);

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);