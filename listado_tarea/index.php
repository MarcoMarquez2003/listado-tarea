<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_task']) && !empty(trim($_POST['new_task']))) {
        $task = trim($_POST['new_task']);
        if (is_string($task)) {
            $_SESSION['tasks'][] = $task;
        }
    }

    if (isset($_POST['delete_task'])) {
        $task_index = $_POST['delete_task'];
        if (isset($_SESSION['tasks'][$task_index])) {
            unset($_SESSION['tasks'][$task_index]);
            $_SESSION['tasks'] = array_values($_SESSION['tasks']); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .task-list {
            margin-top: 20px;
        }
        .task {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .task span {
            font-size: 16px;
            color: #555;
        }
        .delete-btn {
            background-color: #d9534f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #c9302c;
        }
        .no-tasks {
            text-align: center;
            font-size: 16px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>

        <form method="POST">
            <input type="text" name="new_task" placeholder="Nueva tarea..." required>
            <button type="submit">Agregar</button>
        </form>

        <div class="task-list">
            <?php if (!empty($_SESSION['tasks'])): ?>
                <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                    <div class="task">
                        <span><?= is_string($task) ? htmlspecialchars($task) : '[Tarea inválida]'; ?></span>
                        <form method="POST" style="margin: 0;">
                            <input type="hidden" name="delete_task" value="<?= $index; ?>">
                            <button type="submit" class="delete-btn">Eliminar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-tasks">No hay tareas en la lista.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
