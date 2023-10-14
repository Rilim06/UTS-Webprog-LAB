<?php
session_start();
require_once("db.php");

$sql = "SELECT * FROM list WHERE id = ?";

$stmt = $db->prepare($sql);
$data = [$_POST['id']];
$stmt->execute($data);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $row["id"] ?>" />
    <label>Quest Title : </label>
    <input type="text" name="name" value="<?= $row["task_name"] ?>" /><br />
    <label>Quest Detail : </label>
    <input type="text" name="description" value="<?= $row["task_desc"] ?>" /><br />
    <input type="submit" />
</form>