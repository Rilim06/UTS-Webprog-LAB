<?php
session_start();
require_once("db.php");

$sql = "INSERT INTO list(`task_name`, task_desc, tanggal, `status`, `id_user`)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $db->prepare($sql);
$data = [$_POST['name'], $_POST['description'], $_POST['tanggal'], 'Not yet started', $_SESSION['id']];
$stmt->execute($data);

header("Location: index.php");
?>