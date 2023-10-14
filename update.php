<?php
session_start();
require_once("db.php");

$sql = "UPDATE list SET `task_name` = ?, task_desc = ?, tanggal = ? WHERE id = ?";

$stmt = $db->prepare($sql);
$data = [$_POST['name'], $_POST['description'], $_POST['tanggal'], $_POST['id']];
$stmt->execute($data);

header("Location: index.php");
?>