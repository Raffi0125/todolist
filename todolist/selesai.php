<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mysqli->query("UPDATE tasks SET status='Selesai' WHERE id=$id");
    $_SESSION['msg'] = "Task ditandai selesai.";
    header("Location: index.php");
    exit;
}
?>
