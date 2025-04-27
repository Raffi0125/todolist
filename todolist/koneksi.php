<?php
$mysqli = new mysqli("localhost", "root", "", "todo_app");
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
