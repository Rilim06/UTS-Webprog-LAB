<?php
session_start();
require_once("db.php");

$sql = "UPDATE list SET `status` = ? WHERE id = ?";

$stmt = $db->prepare($sql);
$data = ['Not yet started', $_POST['id']];
$stmt->execute($data);

header("Location: index.php");
?>