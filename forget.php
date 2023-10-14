<h1>Please fill in your data</h1>
<?php if (isset($_GET['same'])): ?>
    <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
        Password can't be the same with the last password.
    </div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
        Username and Data doesn't match.
    </div>
<?php endif; ?>
<?php if (isset($_GET['dif'])): ?>
    <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
        Re-entered password doesn't match.
    </div>
<?php endif; ?>
<form action="forget_process.php" method="POST">
    <label>First Name : </label>
    <input type="text" name="first" placeholder="First Name" required /><br />
    <label>Last Name : </label>
    <input type="text" name="last" placeholder="Last Name" required /><br />
    <label>Username : </label>
    <input type="text" name="username" placeholder="Username" required /><br />
    <label>New Password : </label>
    <input type="password" name="password" placeholder="Password" required /><br />
    <label>Re-enter New Password : </label>
    <input type="password" name="re_password" placeholder="Re-enter Password" required /><br />
    <input type="submit" />
</form>

<a href="login.php">Back</a>