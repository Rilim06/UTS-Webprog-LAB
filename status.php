<?php
session_start();
require_once("db.php");

$sql = "UPDATE list SET `status` = ? WHERE id = ?";

$stmt = $db->prepare($sql);
$data = [$_GET['status'], $_GET['id']];
$stmt->execute($data);

header("Location: index.php");
?>