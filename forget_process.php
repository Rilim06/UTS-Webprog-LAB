<?php
session_start();
require_once("db.php");

$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$_POST['username']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_POST['first'] !== $row['first_name'] || $_POST['last'] !== $row['last_name']) {
    header("Location: forget.php?error=error");
} elseif ($_POST['password'] !== $_POST['re_password']) {
    header("Location: forget.php?dif=error");
} elseif (password_verify($_POST['password'], $row["password"])) {
    header("Location: forget.php?same=error");
} else {
    $password = $_POST["password"];
    $en_pass = password_hash($password, PASSWORD_BCRYPT);

    $sql = "UPDATE user SET `password` = ? WHERE username = ?";

    $stmt = $db->prepare($sql);
    $data = [$en_pass, $_POST['username']];
    $stmt->execute($data);
    header("Location: login.php?change=error");
}