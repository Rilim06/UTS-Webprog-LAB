<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do-list IF330</title>
    <link rel="stylesheet" href="navbar/stylenavbar.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="section2/css/base.css" />
    <link rel="stylesheet" type="text/css" href="section2/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="section1/section1.css" />
    <link rel="stylesheet" type="text/css" href="aos/styleaos.css" />
    <script src="https://unpkg.com/scrollreveal"></script>
    <style>
        .confirmation {
            display: none;
        }

        .custom-dialog {
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            position: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-dialog-content {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }

        .custom-dialog-content p {
            font-size: 16px;
            margin: 0;
            padding: 10px 0;
        }

        .custom-dialog-content button {
            background-color: blue;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .custom-dialog-content button:hover {
            background-color: darkblue;
        }
    </style>
    <link rel="stylesheet" href="./styles/index.css">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>
<?php
session_start();
require_once("db.php");
?>

<?php
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"])) {
    ?>
    <div class="get-started">
        <h1 class="">Welcome to<br />To-do-list IF330-AL</h1>
        <div>
            <div class="upper">
                <img class="" src="assets\get-started-task-planner.svg" alt="">
                <h2>
                    Get started with our task planner and start organizing your tasks today!
                </h2>
            </div>
            <div class="below">
                <a href="login.php" class="">
                    <button class="button">
                        Get Started
                        <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
                            <path clip-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </a>
            </div>
        </div>
    </div>
    <?php
} else {

    if (isset($_GET['error'])) {
        ?>
        <div class='alert alert-danger text-center w-80 mx-auto fw-bold' role='alert'>
            Selected quest has been removed.
        </div>
        <?php
    }

    ?>
    <div class="border-2 opacity-0"></div>
    <header class="shadow-md bg-[var(--almond)]">
        <h1 class="text-1xl md:text-2xl lg:text-3xl ms-4 font-bold">Welcome,
            <?= htmlspecialchars($_SESSION['username']) ?>
        </h1>
        <?php
        if (isset($_SESSION["id"]) && isset($_SESSION["username"])) {
            if ($_SESSION["username"] == 'admin') {
                ?>
                <li class="font-semibold text-lg"><a href="add.php">Add Quest</a></li>
                <?php
            } else {
                ?>
                <li class="font-semibold text-lg"><a href="add.php">Add Quest</a></li>
                <?php
            }
        } else { ?>
            <li class="font-semibold text-lg"><a href="add.php">Add Quest</a></li>
            <?php
        }
        ?>
        <li class="font-semibold text-lg"><a href="#" class="font-semibold text-lg">About Us</a></li>
        </ul>
        <div class="main">
            <?php
            if (!isset($_SESSION["id"]) && !isset($_SESSION["nim"])) { ?>
                <a href="login.php" class="user font-semibold text-lg"><i class="ri-user-fill"></i>Sign In</a>
                <?php
            } else { ?>
                <a href='logout.php' class="user font-semibold text-lg"><i class="ri-user-fill"></i>Logout</a>
            <?php }
            ?>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>
    <div class="text-right me-4 md:8 lg:me-10 md:text-xl mt-24 xl:mt-32 2xl:mt-40" id='status'>
        Show:
        <b>
            <select class="border-[1px] border-gray-800 rounded-md" name='status' id='status-select'>
                <option value='All'>All</option>
                <option value='Not yet started'>Not yet started</option>
                <option value='Ongoing'>Ongoing</option>
                <option value='Done'>Done</option>
            </select>
        </b>
    </div>
    <div class="mobile-desktop">
        <div id='not-yet-started'>
            <p class="banner bg-red-300">| Not Yet Started</p>
            <?php
            $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Not yet started'";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class='box'>
                    <div class="left">
                        <div class="title">
                            <?= $row['task_name'] ?>
                        </div>
                        <div class="desc">
                            <?= $row['task_desc'] ?>
                        </div>
                        <div class="date">
                            Due:
                            <?= $row['tanggal'] ?>
                        </div>
                    </div>
                    <div class="flex gap-6 justify-between">
                        <div class="middle">
                            <form class="m-0" id='checkboxForm<?= $row['id'] ?>' method='POST' action='checkbox.php'>
                                <label class="checkbox-container">
                                    <input class="checkbox" type='checkbox' id='checkboxID<?= $row['id'] ?>'
                                        onclick='checkbox(<?= $row["id"] ?>)'>
                                    <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                    <svg viewBox="0 0 64 64" height="2em" width="2em">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            pathLength="575.0541381835938" class="path"></path>
                                    </svg>
                                </label>
                            </form>
                            <div id='row-status'>
                                <select name='status' id='row-status-select-<?= $row['id'] ?>'
                                    onchange='redirectToStatusPage(this)'>
                                    <option value='Not yet started' <?= ($row['status'] == 'Not yet started' ? 'selected' : '') ?>>
                                        Not
                                        yet
                                        started</option>
                                    <option value='Ongoing' <?= ($row['status'] == 'Ongoing' ? 'selected' : '') ?>>Ongoing</option>
                                    <option value='Done' <?= ($row['status'] == 'Done' ? 'selected' : '') ?>>Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="right">
                            <form class="deleteBtn" id='delete<?= $row['id'] ?>' action='delete.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                <button type='button' onclick='openCustomDialog(<?= $row["id"] ?>)'>Remove</button>
                            </form>
                            <form class="editBtn" id='edit<?= $row['id'] ?>' action='edit.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row["id"] ?>'>
                                <button type='submit'>Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div id='ongoing'>
            <p class="banner bg-yellow-100">| Ongoing</p>
            <?php
            $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Ongoing'";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class='box'>
                    <div class="left">
                        <div class="title">
                            <?= $row['task_name'] ?>
                        </div>
                        <div class="desc">
                            <?= $row['task_desc'] ?>
                        </div>
                        <div class="date">
                            Due:
                            <?= $row['tanggal'] ?>
                        </div>
                    </div>
                    <div class="flex gap-6 justify-between">
                        <div class="middle">
                            <form class="m-0" id='checkboxForm<?= $row['id'] ?>' method='POST' action='checkbox.php'>
                                <label class="checkbox-container">
                                    <input type='checkbox' id='checkboxID<?= $row['id'] ?>'
                                        onclick='checkbox(<?= $row["id"] ?>)'>
                                    <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                    <svg viewBox="0 0 64 64" height="2em" width="2em">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            pathLength="575.0541381835938" class="path"></path>
                                    </svg>
                                </label>
                            </form>
                            <div id='row-status'>
                                <select name='status' id='row-status-select-<?= $row["id"] ?>'
                                    onchange='redirectToStatusPage(this)'>
                                    <option value='Not yet started' <?= ($row['status'] == 'Not yet started' ? 'selected' : '') ?>>
                                        Not
                                        yet
                                        started</option>
                                    <option value='Ongoing' <?= ($row['status'] == 'Ongoing' ? 'selected' : '') ?>>Ongoing</option>
                                    <option value='Done' <?= ($row['status'] == 'Done' ? 'selected' : '') ?>>Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="right">
                            <form class="deleteBtn" id='delete<?= $row['id'] ?>' action='delete.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                <button type='button' onclick='openCustomDialog(<?= $row["id"] ?>)'>Remove</button>
                            </form>
                            <form class="editBtn" id='edit<?= $row['id'] ?>' action='edit.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                <button type='submit'>Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div id='done'>
            <p class="banner bg-[var(--celadon)]">| Done</p>
            <?php
            $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Done'";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class='box'>
                    <div class="left">
                        <div class="title">
                            <?= $row['task_name'] ?>
                        </div>
                        <div class="desc">
                            <?= $row['task_desc'] ?>
                        </div>
                        <div class="date">
                            Due:
                            <?= $row['tanggal'] ?>
                        </div>
                    </div>
                    <div class="flex gap-6 justify-between">
                        <div class="middle">
                            <form class="m-0" id='checkboxForm<?= $row['id'] ?>' method='POST' action='checkboxrev.php'>
                                <label class="checkbox-container">
                                    <input type='checkbox' id='checkboxID<?= $row['id'] ?>'
                                        onclick='checkboxrev(<?= $row["id"] ?>)' checked>
                                    <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                    <svg viewBox="0 0 64 64" height="2em" width="2em">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            pathLength="575.0541381835938" class="path"></path>
                                    </svg>
                                </label>
                            </form>
                            <div id='row-status'>
                                <select name='status' id='row-status-select-<?= $row['id'] ?>'
                                    onchange='redirectToStatusPage(this)'>
                                    <option value='Not yet started' <?= ($row['status'] == 'Not yet started' ? 'selected' : '') ?>>
                                        Not
                                        yet
                                        started</option>
                                    <option value='Ongoing' <?= ($row['status'] == 'Ongoing' ? 'selected' : '') ?>>Ongoing</option>
                                    <option value='Done' <?= ($row['status'] == 'Done' ? 'selected' : '') ?>>Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="right">
                            <form class="deleteBtn" id='delete<?= $row['id'] ?>' action='delete.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                <button type='button' onclick='openCustomDialog(<?= $row["id"] ?>)'>Remove</button>
                            </form>
                            <form class="editBtn" id='edit<?= $row['id'] ?>' action='edit.php' method='POST'>
                                <input type='hidden' name='id' value='<?= $row['id'] ?>'>
                                <button type='submit'>Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
}
?>
    </div>
</div>


<div class="confirmation" id="confirmation">
    <div id="customDialog" class="custom-dialog">
        <div class="custom-dialog-content">
            <p>Are you sure you want to delete this Quest?</p>
            <button id="confirmButton">Yes</button>
            <button onclick="closeCustomDialog()">No</button>
        </div>
    </div>
</div>

<script>
    function redirectToStatusPage(selectElement) {

        var selectedValue = selectElement.value;

        var rowId = selectElement.id.split('-').pop();
        
        window.location = 'status.php?id=' + rowId + '&status=' + selectedValue;
    }
</script>

<script>
    var customDialog = document.getElementById("confirmation");

    function openCustomDialog(id) {
        customDialog.style.display = "block";

        document.getElementById("confirmButton").addEventListener("click", function () {
            document.getElementById('delete' + id).submit();
            closeCustomDialog();
        });
    }

    function closeCustomDialog() {
        customDialog.style.display = "none";
    }
</script>

<script>
    function checkbox(id) {
        document.getElementById('checkboxForm' + id).submit();
    }
    function checkboxrev(id) {
        document.getElementById('checkboxForm' + id).submit();
    }
</script>

<script>
    var statusSelect = document.getElementById("status-select");
    var notYetStartedStatus = document.getElementById("not-yet-started");
    var onGoingStatus = document.getElementById("ongoing");
    var doneStatus = document.getElementById("done");

    statusSelect.addEventListener('change', function () {
        var selectedValue = statusSelect.value;

        if (selectedValue === 'All') {
            notYetStartedStatus.style.display = 'block';
            onGoingStatus.style.display = 'block';
            doneStatus.style.display = 'block';
        }

        if (selectedValue === 'Not yet started') {
            notYetStartedStatus.style.display = 'block';
            onGoingStatus.style.display = 'none';
            doneStatus.style.display = 'none';
        }

        if (selectedValue === 'Ongoing') {
            notYetStartedStatus.style.display = 'none';
            onGoingStatus.style.display = 'block';
            doneStatus.style.display = 'none';
        }
        if (selectedValue === 'Done') {
            notYetStartedStatus.style.display = 'none';
            onGoingStatus.style.display = 'none';
            doneStatus.style.display = 'block';
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script>
    ScrollReveal({
        reset: true,
        distance: '60px',
        duration: 2500,
        delay: 400
    });
    ScrollReveal().reveal('.main-title, .section-title', { delay: 500, origin: 'left' });
    ScrollReveal().reveal('.sec-01, .image, .info', { delay: 600, origin: 'bottom' });
    ScrollReveal().reveal('.text-box', { delay: 700, origin: 'right' });
    ScrollReveal().reveal('.media-icons i', { delay: 500, origin: 'bottom', interval: 200 });
    ScrollReveal().reveal('.sec-02 .image, .sec-03 .image', { delay: 500, origin: 'top' });
    ScrollReveal().reveal('.media-info li', { delay: 500, origin: 'left', interval: 200 });
</script>
<script type="text/javascript">
    class Slider {
        constructor(props) {
            this.rootElement = props.element;
            this.slides = Array.from(
                this.rootElement.querySelectorAll(".slider-list__item")
            );
            this.slidesLength = this.slides.length;
            this.current = 0;
            this.isAnimating = false;
            this.direction = 1; // -1
            this.baseAnimeSettings = {
                rotation: 45,
                duration: 750,
                easing: 'easeInOutCirc'
            };
            this.baseAnimeSettingsBack = {
                rotation: 45,
                duration: 1850,
                elasticity: (el, i, l) => 200 + i * 200
            };
            this.baseAnimeSettingsFront = {
                rotation: 45,
                duration: 2250,
                elasticity: (el, i, l) => 200 + i * 200
            };
            this.baseAnimeSettingsTitle = {
                rotation: 45,
                duration: 1750,
                elasticity: (el, i, l) => 200 + i * 200
            };

            this.navBar = this.rootElement.querySelector(".slider__nav-bar");
            this.thumbs = Array.from(this.rootElement.querySelectorAll(".nav-control"));
            this.prevButton = this.rootElement.querySelector(".slider__arrow_prev");
            this.nextButton = this.rootElement.querySelector(".slider__arrow_next");

            this.slides[this.current].classList.add("slider-list__item_active");
            this.thumbs[this.current].classList.add("nav-control_active");

            this._bindEvents();
        }

        goTo(index, dir) {
            if (this.isAnimating) return;
            let prevSlide = this.slides[this.current];
            let nextSlide = this.slides[index];

            this.isAnimating = true;
            this.current = index;
            nextSlide.classList.add("slider-list__item_active");

            anime({
                ...this.baseAnimeSettings,
                targets: nextSlide,
                rotate: [90 * dir + 'deg', 0],
                translateX: [90 * dir + '%', 0]
            });

            anime({
                ...this.baseAnimeSettingsBack,
                targets: nextSlide.querySelectorAll('.back__element'),
                rotate: [90 * dir + 'deg', 0],
                translateX: [90 * dir + '%', 0]
            });

            anime({
                ...this.baseAnimeSettingsFront,
                targets: nextSlide.querySelectorAll('.front__element'),
                rotate: [90 * dir + 'deg', 0],
                translateX: [90 * dir + '%', 0]
            });

            anime({
                ...this.baseAnimeSettingsTitle,
                targets: nextSlide.querySelectorAll('.title__element'),
                rotate: [90 * dir + 'deg', 0],
                translateX: [90 * dir + '%', 0]
            });

            anime({
                ...this.baseAnimeSettings,
                targets: prevSlide,
                rotate: [0, -90 * dir + 'deg'],
                translateX: [0, -150 * dir + '%'],
                complete: (anim) => {
                    this.isAnimating = false;
                    prevSlide.classList.remove("slider-list__item_active");
                    this.thumbs.forEach((item, index) => {
                        const action = index === this.current ? "add" : "remove";
                        item.classList[action]("nav-control_active");
                    });
                }
            });

            anime({
                ...this.baseAnimeSettingsBack,
                targets: prevSlide.querySelectorAll('.back__element'),
                rotate: [0, -90 * dir + 'deg'],
                translateX: [0, -150 * dir + '%']
            });

            anime({
                ...this.baseAnimeSettingsFront,
                targets: prevSlide.querySelectorAll('.front__element'),
                rotate: [0, -90 * dir + 'deg'],
                translateX: [0, -150 * dir + '%']
            });

            anime({
                ...this.baseAnimeSettingsTitle,
                targets: prevSlide.querySelectorAll('.title__element'),
                rotate: [0, -90 * dir + 'deg'],
                translateX: [0, -150 * dir + '%']
            });
        }

        goStep(dir) {
            let index = this.current + dir;
            let len = this.slidesLength;
            let currentIndex = (index + len) % len;
            this.goTo(currentIndex, dir);
        }

        goNext() {
            this.goStep(1);
        }

        goPrev() {
            this.goStep(-1);
        }

        _navClickHandler(e) {
            if (this.isAnimating) return;
            let target = e.target.closest(".nav-control");
            if (!target) return;
            let index = this.thumbs.indexOf(target);
            if (index === this.current) return;
            let direction = index > this.current ? 1 : -1;
            this.goTo(index, direction);
        }

        _bindEvents() {
            ["goNext", "goPrev", "_navClickHandler"].forEach((method) => {
                this[method] = this[method].bind(this);
            });
            this.nextButton.addEventListener("click", this.goNext);
            this.prevButton.addEventListener("click", this.goPrev);
            this.navBar.addEventListener("click", this._navClickHandler);
        }
    }

    let slider = new Slider({
        element: document.querySelector(".slider")
    });
</script>
<script type="text/javascript">
    let menu = document.querySelector('#menu-icon');
    let navbar = document.querySelector('.navbar');

    menu.onclick = () => {
        menu.classList.toggle('bx-x');
        navbar.classList.toggle('open');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script type="text/javascript">
    var typed = new Typed(".multiple-text", {
        strings: ["Frontend Developer", "YouTuber", "Blogger"],
        typeSpeed: 100,
        backSpeed: 100,
        backDelay: 1000,
        loop: true
    })
</script>