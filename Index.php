<?php
// File to store tasks
$tasksFile = 'tasks.json';

// Load existing tasks from the file
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true);
} else {
    $tasks = [];
}

// Add a new task via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $newTask = [
        'id' => count($tasks) + 1,
        'task' => htmlspecialchars($_POST['task'])
    ];
    $tasks[] = $newTask;

    // Save tasks back to the file
    file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
}

// Display tasks
echo "<h2>My PHP To-Do List</h2>";
if (!empty($tasks)) {
    echo "<ul>";
    foreach ($tasks as $task) {
        echo "<li>{$task['id']}: {$task['task']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No tasks yet!</p>";
}

// Form to add tasks
echo '<form method="POST">
        <input type="text" name="task" placeholder="New task" required>
        <button type="submit">Add Task</button>
      </form>';
?>
