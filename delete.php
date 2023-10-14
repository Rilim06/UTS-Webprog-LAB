<?php
session_start();
require_once("db.php");

$sql = "DELETE FROM list WHERE id = ?";

$stmt = $db->prepare($sql);
$data = [$_POST['id']];
$stmt->execute($data);

header("Location: index.php?error=error");
?>