<h1>Login</h1>
<?php
session_start();
?>
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
<?php
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"])) {
    ?>
    <form action="login_process.php" method="POST">
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
    <a href="register.php">Register Now</a>
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