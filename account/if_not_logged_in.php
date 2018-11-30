<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>
    <!--Import basic imports-->
    <?php imports() ?>
    <?php
        if(isset($_POST['fname']) && isset($_POST['lname'])){
            session_start();
            $_SESSION['unregistered_user'] = $_POST['email'];
            $_SESSION['loggedin'] = true;
            db_connect();
            header('Location: /products/payment.php');
        }
    ?>
</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container content center">
    <div class="row center" id="scroll">
        <div class="col s22 m5">
            <div class="card">
                <div class="card">

                </div>
                <div class="card-action text center">
                    <a class="dark_grey_color">Continue without registration</a><br>
                </div>
                <div class="card-action left text card_tekst">
                    <form method="POST" class="registerinput left">
                        <div class="required"><br></div>
                        First name: <input type="text" name="fname" id="fname" class="rinputs" required><br>
                        Last name: <input type="text" name="lname" id="lname" class="rinputs" required><br>
                        E-Mail: <input type="email" name="email" id="email" class="rinputs" required>
                        <span class="required"></span><br>
                        Password: <input type="password" name="password" id="password" class="rinputs" required>
                        <span class="required"></span><br>
                        Address: <input type="text" name="address" id="address" class="rinputs" required>
                        <span class="required"></span><br>
                        Postal Code: <input type="text" name="postalcode" id="postalcode" class="rinputs"
                                                   required>
                        <span class="required"></span><br><br>
                        <div id="recaptcha" class="g-recaptcha" data-callback="recaptchacallback"
                             data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
                        <button type="submit" name="registerbutton" id="submit_button"
                                class="btnregister s12 btn disabled btn-large waves-effect">Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col s22 m5">
            <div class="card">
                <div class="card">
                </div>
                    <div class="card-action center text card_tekst">
                        <br><br><br><br><br><br><br><br><br>
                        <a class="waves-effect waves-light btn-large dark_blue_color_backround" href="inlog.php">  Login now  </a>
                        <br><br><br><br><br>
                        <a class="waves-effect waves-light btn-large dark_blue_color_backround" href="register.php">Register now</a>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </div>
            </div>
        </div>
    </div>
</div>


<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>
<!--Include functions.js-->
<script type="text/javascript" src="/js/functions.js"></script>
</body>
</html>