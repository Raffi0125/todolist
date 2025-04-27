<?php
session_start();
require_once'Koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mysqli->query("UPDATE tasks SET status='Selesai' WHERE id=$id");
    $_SESSION['msg'] = "Task ditandai selesai.";
    header("Location: index.php");
    exit;
}
?>
