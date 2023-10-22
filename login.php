<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles\login.css" />
    <title>Sign in & Sign up Form</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="login_process.php" method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <?php if (isset($_GET['empty'])): ?>
                        <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
                            Username or Password incorrect.
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
                            Please fill in all the fields.
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['captcha'])): ?>
                        <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
                            Captcha incorrect.
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['change'])): ?>
                        <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
                            Password successfully changed.
                        </div>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>

                        <input type="text" name="username" placeholder="Username" /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>

                        <input type="password" name="password" placeholder="Password" /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-solid fa-key"></i>
                        <?php $captcha = generateCaptcha() ?>

                        <input type="text" name="captcha" placeholder="Enter Captcha" />
                    </div>
                    <label>
                        <?php echo $captcha; ?>
                    </label>
                    <input type="hidden" name="captcha_generate" value="<?php echo $captcha; ?>" /><br />
                    <input type="submit" value="Login" class="btn solid" />
                </form>
                <form action="register_process.php" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
                            Username already taken.
                        </div>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="first" placeholder="First Name" required /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="last" placeholder="Last Name" required /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-inbox"></i>
                        <input type="text" name="username" placeholder="Username" required /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-regular fa-calendar"></i>
                        <input type="date" name="tanggal" placeholder="Tanggal Lahir" required /><br />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-venus-mars"></i>
                        <select class="input-radio" placeholder="Gender">
                            <option id="gdr" name="gender" value="Male">Male</option>
                            <option id="gdr" name="gender" value="Female">Female</option>
                        </select>
                        <br />
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <!-- <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p> -->
                    <br>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="loginpage/img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <!-- <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p> -->
                    <br />
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="loginpage/img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>

</html>


<?php
if (isset($_SESSION["id"]) && isset($_SESSION["username"])) {
    header('Location: index.php');
}
?>

<!-- <form action="login_process.php" method="POST">
    <label>Username : </label>
    <input type="text" name="username" placeholder="Username" /><br />
    <label>Password : </label>
    <input type="password" name="password" placeholder="Password" /><br />
    <?php $captcha = generateCaptcha() ?>
    <label>Captcha : </label>
    <input type="text" name="captcha" placeholder="Enter Captcha" />
    <label>
        <?php echo $captcha; ?>
    </label>
    <input type="hidden" name="captcha_generate" value="<?php echo $captcha; ?>" /><br />
    <button type="submit">Login</button>
</form>
<a href="forget.php">Forget Password?</a>
<p>Don't have an account?</p>
<a href="register.php">Register Now</a> -->

<?php
function generateCaptcha($length = 5)
{
    $numbers = '0123456789';
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $randomNumber = $numbers[rand(0, strlen($numbers) - 1)];

    $randomLetters = '';
    for ($i = 0; $i < ($length - 1); $i++) {
        $randomLetters .= $letters[rand(0, strlen($letters) - 1)];
    }

    $randomCaptcha = $randomNumber . $randomLetters;
    $randomCaptcha = str_shuffle($randomCaptcha);

    return $randomCaptcha;
}

?>