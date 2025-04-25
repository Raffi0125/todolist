<?php
session_start();
include 'db.php';

if (isset($_POST['tambah'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $date = date("Y-m-d");
    $status = "Belum Selesai";

    $mysqli->query("INSERT INTO tasks (task, priority, date, due_date, status)
                    VALUES ('$task', '$priority', '$date', '$due_date', '$status')");

    $_SESSION['msg'] = "Task berhasil ditambahkan.";
    header("Location: index.php");
    exit;
}
?>
