<?php
session_start();
require_once("db.php");

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_POST['username'] == NULL || $_POST['password'] == NULL || $_POST['captcha'] == NULL) {
    header("Location: login.php?error=error");
} elseif (!password_verify($password, $row["password"])) {
    header("Location: login.php?empty=error");
} elseif ($_POST['captcha'] !== $_POST['captcha_generate']) {
    header("Location: login.php?captcha=error");
} else {
    $_SESSION["id"] = $row["id"];
    $_SESSION["username"] = $row["username"];
    header("Location: index.php");
}