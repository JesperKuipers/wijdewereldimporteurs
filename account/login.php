<!DOCTYPE html>
<html>
<head>
    <?php session_start(); ?>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>
    <!--Include database_connectie-->
    <?php include '../database_connectie.php'; ?>
    <!--Import basic imports-->
    <?php imports() ?>
</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container center content ">
    <div class="row" style="width: 320px;">

        <div class="card">
            <div class="card-action text center ">
                <a class="dark_grey_color">Please log into your account</a><br>
            </div>
            <div class="card-action left text card_tekst col s22 m12">
                <form method="POST" name="login" action="login_process.php">
                    Username: <input type="email" name="email" class="logininput" placeholder="Enter your E-Mail"
                                     required><br>
                    Password: <input type="password" name="password" id="password" class="logininput"
                                     placeholder="Enter your password" required><br>
                    <label><a class="forgotpassword dark_blue_color" href="password_forgot.php"><u>Forgot
                                Password</u></a></label><br><br>
                    <button type="submit" name="loginbutton" class="btnlogin s12 btn btn-large waves-effect">Login
                    </button>
                </form>
                <form>
                    <label><br><a class="createaccount dark_blue_color" href="register.php"><u>Create Account</u></a></label>
                </form>
            </div>
        </div>
    </div>

</div>
</div>

<?php

?>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>

