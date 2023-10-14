<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center w-80 mx-auto fw-bold" role="alert">
        Username already taken.
    </div>
<?php endif; ?>

<form action="register_process.php" method="POST">
    <label>First Name : </label>
    <input type="text" name="first" placeholder="First Name" required /><br />
    <label>Last Name : </label>
    <input type="text" name="last" placeholder="Last Name" required /><br />
    <label>Username : </label>
    <input type="text" name="username" placeholder="Username" required /><br />
    <label>Password : </label>
    <input type="password" name="password" placeholder="Password" required /><br />
    <label>Tanggal Lahir : </label>
    <input type="date" name="tanggal" required /><br />
    <label>Jenis Kelamin : </label>
    <input type="radio" name="gender" value="Male" required /> Laki-laki
    <input type="radio" name="gender" value="Female" required /> Perempuan
    <br />
    <input type="submit" />
</form>

<p>Already have an account?</p>
<a href="login.php">Login</a>