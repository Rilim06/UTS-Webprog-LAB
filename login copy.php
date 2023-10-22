<head>
    <link rel="stylesheet" href="styles\login.css">
</head>
<!-- <h1>Login</h1> -->
<!-- <?php
session_start();
?>
<?php if (isset($_GET['empty'])): ?>
    <div class="alert" role="alert">
        Username or Password incorrect.
    </div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert" role="alert">
        Please fill in all the fields.
    </div>
<?php endif; ?>
<?php if (isset($_GET['captcha'])): ?>
    <div class="alert" role="alert">
        Captcha incorrect.
    </div>
<?php endif; ?>
<?php if (isset($_GET['change'])): ?>
    <div class="alert" role="alert">
        Password successfully changed.
    </div>
<?php endif; ?> -->
<?php
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"])) {
    ?>
    <div class="login">
        <form class="form" action="login_process.php" method="POST">
            <h1 class="title">Login</h1>
            <?php if (isset($_GET['empty'])): ?>
                <div class="alert" role="alert">
                    Username or Password incorrect.
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert" role="alert">
                    Please fill in all the fields.
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['captcha'])): ?>
                <div class="alert" role="alert">
                    Captcha incorrect.
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['change'])): ?>
                <div class="alert" role="alert">
                    Password successfully changed.
                </div>
            <?php endif; ?>
            <label>
                <input required="" placeholder="" type="text" class="input" name="username">
                <span>Username</span>
            </label>
            <label>
                <input required="" placeholder="" type="password" class="input" name="password" />
                <span>Password</span>
            </label>
            <?php $captcha = generateCaptcha() ?>
            <div class="flex">
                <label>
                    <input required="" placeholder="" type="text" class="input" name="captcha" />
                    <span>Captcha</span>
                </label>
                <p><?php echo $captcha; ?></p>
            </div>
            <input type="hidden" name="captcha_generate" value="<?php echo $captcha; ?>" />
            <button class="submit" type="submit">Login</button>
            <p class="signin"><a href="forget.php">Forget Password?</a></p>
            <p class="signin">Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
    <?php
} else {
    header("Location: index.php");
}
?>

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