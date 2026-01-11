<?php
header('Content-Type: application/json');

// File to store tasks
$tasksFile = 'tasks.json';

// Load existing tasks
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true);
} else {
    $tasks = [];
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Read input JSON
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['task']) && !empty(trim($input['task']))) {
        $newTask = [
            'id' => count($tasks) + 1,
            'task' => htmlspecialchars(trim($input['task']))
        ];
        $tasks[] = $newTask;

        // Save back to JSON file
        file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
    }

    echo json_encode($tasks);
    exit;
}

// Default: return all tasks
echo json_encode($tasks);
