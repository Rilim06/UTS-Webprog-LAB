<?php
$data = [
    "hans" => [
        "id" => "1",
        "image" => "./assets/myson.jpg",
        "nama" => "Hans Philemon Limanza",
        "nim" => "00000070710",
        "ig" => "https://www.instagram.com/hans.pl/",
        "profile" => "@hans.pl"
    ],
    "jackson" => [
        "id" => "2",
        "image" => "./assets/walaw.jpg",
        "nama" => "Jackson Lawrence",
        "nim" => "00000070612",
        "ig" => "https://www.instagram.com/jacksonciek/",
        "profile" => "@jacksonciek"
    ],
    "louis" => [
        "id" => "3",
        "image" => "./assets/achoi.jpg",
        "nama" => "Louis Gabriel Hernandes",
        "nim" => "00000070250",
        "ig" => "https://www.instagram.com/lou1s.gh/",
        "profile" => "@lou1s.gh"
    ],
    "rich" => [
        "id" => "4",
        "image" => "./assets/dad.jpg",
        "nama" => "Rich Marvin Lim",
        "nim" => "00000079061",
        "ig" => "https://www.instagram.com/rmarvin_/",
        "profile" => "@rmarvin_"
    ],
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker IF330</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="about.css">
   <style>
    body{
        overflow-x: hidden;
        background: url("./assets/bg.jpg");
        background-repeat: no-repeat;
  background-size: cover;
    }
   </style>
</head>

<body>
    <div class="container">
        <div class="flex justify-center items-center">
            <a href="index.php" class="text-lg font-bold text-black">Back to Home</a>
        </div>
        <div class="card__container pt-6">
            <?php foreach ($data as $key => $value) : ?>
                <article class="card__article">
                    <img src="<?php echo $value['image']; ?>" alt="<?php echo $value['nama']; ?>" class="card__img">
                    <div class="card__data">
                        <span class="card__description">
                            <?php echo $value['nama']; ?>
                        </span>
                        <h2 class="card__title">Student ID:
                            <?php echo $value['nim']; ?>
                        </h2>
                        <a href="<?php echo $value['ig']; ?>" class="card__button" target="_blank">Instagram:
                            <?php echo $value['profile']; ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <script type="text/javascript">
        let menu = document.querySelector('#menu-icon');
        let navbar = document.querySelector('.navbar');

        menu.onclick = () => {
            menu.classList.toggle('bx-x');
            navbar.classList.toggle('open');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>