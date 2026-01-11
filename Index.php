<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full-Stack PHP To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 2em auto; }
        h2 { color: #2c3e50; }
        ul { list-style-type: none; padding: 0; }
        li { background: #ecf0f1; margin: 5px 0; padding: 10px; border-radius: 5px; }
        input[type=text] { padding: 8px; width: 70%; margin-right: 10px; }
        button { padding: 8px 12px; }
    </style>
</head>
<body>

<h2>My Full-Stack PHP To-Do List</h2>

<form id="task-form">
    <input type="text" id="task" placeholder="New task" required>
    <button type="submit">Add Task</button>
</form>

<ul id="task-list">
    <!-- Tasks will be dynamically inserted here -->
</ul>

<script>
async function fetchTasks() {
    const res = await fetch('tasks_api.php');
    const data = await res.json();
    displayTasks(data);
}

function displayTasks(tasks) {
    const ul = document.getElementById('task-list');
    ul.innerHTML = '';
    tasks.forEach(t => {
        const li = document.createElement('li');
        li.textContent = `${t.id}: ${t.task}`;
        ul.appendChild(li);
    });
}

document.getElementById('task-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const taskInput = document.getElementById('task');
    if (!taskInput.value.trim()) return;

    await fetch('tasks_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ task: taskInput.value })
    });

    taskInput.value = '';
    fetchTasks();
});

// Load tasks when page loads
fetchTasks();
</script>

</body>
</html>
