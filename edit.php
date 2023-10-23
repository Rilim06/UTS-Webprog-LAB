<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do-list IF330</title>
    <link rel="stylesheet" href="styles\add.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
session_start();
require_once("db.php");

$sql = "SELECT * FROM list WHERE id = ?";

$stmt = $db->prepare($sql);
$data = [$_POST['id']];
$stmt->execute($data);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="flex justify-center">
    <form class="form" action="update.php" method="POST">
        <div class="header">Edit Quest</div>
        <div class="inputs">
            <input type="hidden" name="id" value="<?= $row["id"] ?>" />
            <!-- <label>Quest Title : </label> -->
            <input class="input" type="text" name="name" value="<?= $row["task_name"] ?>" placeholder="Title"
                required />
            <!-- <label>Quest Detail : </label> -->
            <input class="input" type="text" name="description" value="<?= $row["task_desc"] ?>"
                placeholder="Description" required />
            <label>Due Date : </label>
            <input class="input" type="date" name="tanggal" value="<?= $row["tanggal"] ?>" placeholder="Date"
                required />
            <input type="submit" value="" hidden>
            <button class="sigin-btn">Submit</button>
            </input>
        </div>
    </form>
    <a class="backBtn" href="index.php">
        <button
            class="mb-4 relative py-2 px-8 text-black text-base font-bold uppercase rounded-[50px] overflow-hidden bg-gray-200 transition-all duration-400 ease-in-out shadow-md hover:scale-105 hover:text-white hover:shadow-lg active:scale-90 before:absolute before:top-0 before:-left-full before:w-full before:h-full before:bg-gradient-to-r before:from-stone-400 before:to-indigo-900 before:transition-all before:duration-500 before:ease-in-out before:z-[-1] before:rounded-[50px] hover:before:left-0">
            Back
        </button>
    </a>
</div>