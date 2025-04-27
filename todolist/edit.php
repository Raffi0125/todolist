<?php
session_start();
require_once'Koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

if (!$id) {
    $_SESSION['msg'] = "ID tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$result = $mysqli->query("SELECT * FROM tasks WHERE id = $id");
$task_data = $result->fetch_assoc();

if (!$task_data) {
    $_SESSION['msg'] = "Task tidak ditemukan.";
    header("Location: index.php");
    exit;
}

if ($task_data['status'] === 'Selesai') {
    $_SESSION['msg'] = "Task sudah selesai dan tidak bisa diedit.";
    header("Location: index.php");
    exit;
}

// Jika form dikirim
if (isset($_POST['update'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    if (
        $task === $task_data['task'] &&
        $priority === $task_data['priority'] &&
        $due_date === $task_data['due_date']
    ) {
        $_SESSION['msg'] = "Tidak ada perubahan data yang disimpan.";
    } else {
        $mysqli->query("UPDATE tasks SET task='$task', priority='$priority', due_date='$due_date' WHERE id=$id");
        $_SESSION['msg'] = "Task berhasil diupdate.";
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Task</h1>

    <form method="POST" class="form">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="task">Task:</label>
        <input type="text" name="task" id="task" required value="<?= htmlspecialchars($task_data['task']) ?>">

        <label for="priority">Prioritas:</label>
        <select name="priority" id="priority" required>
            <option value="">-- Pilih Prioritas --</option>
            <option value="Low" <?= $task_data['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
            <option value="Medium" <?= $task_data['priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="High" <?= $task_data['priority'] == 'High' ? 'selected' : '' ?>>High</option>
        </select>

        <label for="due_date">Tanggal Jatuh Tempo:</label>
        <input type="date" name="due_date" id="due_date" required min="<?= date('Y-m-d') ?>" value="<?= $task_data['due_date'] ?>">

        <button type="submit" name="update">Update Task</button>
        <a href="index.php" class="btn btn-cancel">Batal</a>
    </form>

    <footer>
        &copy; USP RPL 2025 | Raffi | XII RPL 1
    </footer>
</body>
</html>
