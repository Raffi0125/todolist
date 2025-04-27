<?php
session_start();
require_once'Koneksi.php';

$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $mysqli->query("SELECT * FROM tasks WHERE id = $id");
    $task_data = $result->fetch_assoc();

    if ($task_data['status'] == 'Selesai') {
        $_SESSION['msg'] = "Task sudah selesai dan tidak bisa diedit.";
        header("Location: index.php");
        exit;
    }

    $edit = $task_data;
}

$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

$tasks_pending = $mysqli->query("SELECT * FROM tasks WHERE status != 'Selesai' AND task LIKE '%$search%' ORDER BY id DESC");
$tasks_done = $mysqli->query("SELECT * FROM tasks WHERE status = 'Selesai' AND task LIKE '%$search%' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<h1>To-Do List</h1>

<?php if (isset($_SESSION['msg'])): ?>
    <div class="alert" id="notif"><?= $_SESSION['msg']; ?></div>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

<form method="POST" action="<?= $edit ? 'edit.php' : 'tambah.php' ?>" class="form">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <?php endif; ?>

    <label for="task">Task:</label>
    <input type="text" name="task" id="task" required placeholder="Tambahkan Task Baru"
           value="<?= $edit ? htmlspecialchars($edit['task']) : '' ?>">

    <label for="priority">Prioritas:</label>
    <select name="priority" id="priority" required>
        <option value="">-- Pilih Prioritas --</option>
        <?php
        $priorities = ['Low', 'Medium', 'High'];
        foreach ($priorities as $p) {
            $selected = ($edit && $edit['priority'] === $p) ? 'selected' : '';
            echo "<option value='$p' $selected>$p</option>";
        }
        ?>
    </select>

    <label for="due_date">Tanggal Jatuh Tempo:</label>
    <input type="date" name="due_date" id="due_date" required min="<?= date('Y-m-d') ?>"
           value="<?= $edit ? $edit['due_date'] : '' ?>">

    <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>">
        <?= $edit ? 'Update Task' : 'Tambah' ?>
    </button>

    <?php if ($edit): ?>
        <a href="index.php" class="btn btn-cancel">Batal</a>
    <?php endif; ?>
</form>

<h2>Tasks Belum Selesai</h2>
<div class="card-container">
    <?php if ($tasks_pending->num_rows): ?>
        <?php while ($row = $tasks_pending->fetch_assoc()): ?>
            <?php $is_late = (date("Y-m-d") > $row['due_date']); ?>
            <div class="task-card">
                <h3><?= htmlspecialchars($row['task']) ?></h3>
                <div>
                    <span class="badge <?= strtolower($row['priority']) ?>"><?= $row['priority'] ?></span>
                    <span class="badge pending"><?= $row['status'] ?></span>
                </div>
                <p><strong>Tanggal Input:</strong> <?= date("d-m-Y", strtotime($row['date'])) ?></p>
                <p><strong>Jatuh Tempo:</strong> <?= date("d-m-Y", strtotime($row['due_date'])) ?>
                    <?php if ($is_late): ?><span class="badge overdue">Terlambat</span><?php endif; ?>
                </p>
                <div class="actions">
                    <a href="?edit=<?= $row['id'] ?>" class="btn blue">Edit</a>
                    <a href="selesai.php?id=<?= $row['id'] ?>" class="btn green">Selesai</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn red" onclick="return confirm('Yakin ingin menghapus task ini?')">Hapus</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Task yang belum selesai tidak ditemukan.</p>
    <?php endif; ?>
</div>

<h2>Tasks Sudah Selesai</h2>
<div class="card-container">
    <?php if ($tasks_done->num_rows): ?>
        <?php while ($row = $tasks_done->fetch_assoc()): ?>
            <div class="task-card done">
                <h3><?= htmlspecialchars($row['task']) ?></h3>
                <div>
                    <span class="badge <?= strtolower($row['priority']) ?>"><?= $row['priority'] ?></span>
                    <span class="badge done"><?= $row['status'] ?></span>
                </div>
                <p><strong>Tanggal Input:</strong> <?= date("d-m-Y", strtotime($row['date'])) ?></p>
                <p><strong>Jatuh Tempo:</strong> <?= date("d-m-Y", strtotime($row['due_date'])) ?></p>
                <div class="actions">
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn red" onclick="return confirm('Yakin ingin menghapus task ini?')">Hapus</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Task yang sudah selesai tidak ditemukan.</p>
    <?php endif; ?>
</div>

<footer>
    &copy; USP RPL 2025 | Raffi | XII RPL 1
</footer>

<script src="script.js"></script>
</body>
</html>
