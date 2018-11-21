<!DOCTYPE html>
<html>
<head>
    <?php session_start();?>
    <!--Include functions.php for lay-out-->
    <?php include "../.php/functions.php" ?>
    <!--Include database_connectie-->
    <?php include '.php/database_connectie.php'; ?>
    <!--Import basic imports-->
    <?php imports() ?>?>
</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container-login center content">
    <p><b>Please log into your account</b></p>
    <form method="POST" name="login" action="loginprocess.php">
        <b>Username: </b><input type="email" name="email" class="logininput" placeholder="Enter your E-Mail"
                                onfocus="this.placeholder=''" onblur="this.placeholder='Enter your E-Mail'"
                                required><br>
        <b>Password:</b> <input type="password" name="password" id="password" class="logininput"
                                placeholder="Enter your password" onfocus="this.placeholder=''"
                                onblur="this.placeholder='Enter your password'" required style="margin-left:4px;"><br>
        <label style="float: bottom;">
            <a class="forgotpassword" href="passwordforgot.php"><b><u>Forgot Password</u></b></a>
        </label><br><br>
        <br>
        <button type="submit" name="loginbutton" class="btnlogin s12 btn btn-large waves-effect">Login</button>
    </form>
    <form>
        <label style="float:bottom;font-size: 12pt;">
            <br><br><a class="createaccount" href="register.php"><b><u>Create Account</u></b></a>
        </label>
    </form>
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

