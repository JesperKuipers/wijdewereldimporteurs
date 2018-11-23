<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include ".php/functions.php" ?>
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
    <h1><b class="resetpass">Reset Password</b></h1>
    <form method="POST" class="passforgotinput" action="">
        <b>E-Mail: </b><input type="text" name="email" id="email" class="rinputs" required style="margin-left: 50px"><br>
        <b>Old Password: </b><input type="password" name="password" id="password" class="rinputs" required><br>
        <button type="submit" name="passresetbutton" id="passResetBtn" class="btnpassreset s12 btn btn-large waves-effect">Send</button>
    </form>
    <label style="font-size: 16px">
        <a class="loginhere" href="inlog.php"><b><u>Log in here</u></b></a>
    </label>
</div>


<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>
