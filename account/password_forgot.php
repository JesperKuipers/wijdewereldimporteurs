<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>
    <!--Import basic imports-->
    <?php imports() ?>
</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container-passwordforgot center content">
    <h1><b class="resetpass">Reset Password</h1>
    <form method="POST" class="passforgotinput" action="">
        E-Mail: <input type="text" name="email" id="email" class="rinputs" required style="margin-left: 50px"><br>
        Old Password: <input type="password" name="password" id="password" class="rinputs" required><br>
        <button type="submit" name="passresetbutton" id="passResetBtn" class="btnpassreset s12 btn btn-large waves-effect">Send</button>
    </form>
    <label style="font-size: 16px">
        <a class="loginhere" href="inlog.php"><u>Log in here</u></a>
    </label>
</div>


<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>
