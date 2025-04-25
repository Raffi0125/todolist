<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM tasks WHERE id=$id");
    $_SESSION['msg'] = "Task berhasil dihapus.";
    header("Location: index.php");
    exit;
}
?>
