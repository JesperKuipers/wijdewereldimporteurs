<!DOCTYPE html>
<html>
<head>
    <?php require "../functions.php";
    require '../database_connectie.php';
    ob_start();
    imports() ?>
</head>

<body>

<!--|-------Nav-bar----------------|-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<!-- class="content" is nodig voor sticky footer -->
<div class="container-login center content">
    <p><b>Please log into your account</b></p>
    <form method="POST" name="login" id="login">
        <b>Username: </b><input type="email" name="email" class="logininput" placeholder="Enter your E-Mail"
                                onfocus="this.placeholder=''" onblur="this.placeholder='Enter your E-Mail'"
                                required><br>
        <b>Password:</b> <input type="password" name="password" id="password" class="logininput"
                                placeholder="Enter your password" onfocus="this.placeholder=''"
                                onblur="this.placeholder='Enter your password'" required style="margin-left:4px;"><br>
        <label hidden style="float: bottom;">
            <a class="forgotpassword" href="../passwordforgot.php"><b><u>Forgot Password</u></b></a>
        </label><br><br>
        <?php

        $db = db_connect();
        $stmt = $db->prepare('SELECT * FROM registered_users WHERE email=:email');
        $stmt->execute(array(":email" => $email));
        $row = $stmt->fetch();
        if(isset($_POST['loginbutton'])) {
            if($stmt->rowCount() > 0) {
                if(password_verify($password, $row['password'])) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['customerid'] = $row['customerid'];
                    session_write_close();
                    header('location: /account/account.php');
                } else {
                    ?><p class="loginerror"><b>Uw gebruikersnaam en/of wachtwoord is onjuist</b></p>
                    <?php
                }
            } else {
                ?><p class="loginerror"><b>Uw gebruikersnaam en/of wachtwoord is onjuist</b></p>
                <?php
            }
        }
        ?>
        <br>
        <button type="submit" name="loginbutton" class="btnlogin s12 btn btn-large waves-effect">Login</button>
    </form>
    <form>
        <label style="float:bottom;font-size: 12pt;">
            <br><br><a class="createaccount" href="register.php"><b><u>Create Account</u></b></a>
        </label>
    </form>
</div>


<!--|-----------BEGINNING---------------------------|
    |------------Footer-----------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>