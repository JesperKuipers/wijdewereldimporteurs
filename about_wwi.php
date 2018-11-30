<?php

if (isset($_POST['submit'])) {
    require 'functions.php';
    $errMsg = '';
    $succMsg = '';
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LcBd3oUAAAAABzSR-I4wK4nXxLCM8QixPzt1pOz';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            # to send mail
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
            $mailfrom = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            email($name, $subject, $mailfrom, $message);

        } else {

        }
    } else {

    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <div class="row">
        <div class="col s22 m11">
            <div class="card">
                <div class="card-image">
                    <img src="images/wwi-logo.png">
                </div>
                <div class="card-action center text card_tekst">
                    <a class="dark_grey_color"><b>About WWI</b></a><br>
                </div>
                <div class="card-action card_line_remover">
                    <a class="light_grey_color text">Wijde wereld Importeurs oftewel Wide World Importers is een bedrijf dat een rijk diversiteit aan
                        producten levert.
                        WWI levert hun producten aan grote warenhuizen en groothandels in de Veregeningde Staten en nu ook
                        aan consumenten in Nederland.</a>
                <!--todo: Tekst veranderen -->
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="scroll">
        <div class="col s22 m11">
            <div class="card">
                <div class="card">

                </div>
                <div class="card-action text center">
                    <a class="dark_grey_color center"><b> Contact WWI</b></a><br>
                </div>
                <div class="card-action center text card_tekst">
                    <a class="light_grey_color text">If you would like to contact Wide World Importers, fill the form below in.<br></a>
                    <a class="dark_grey_color text"><b>

                        <form method="post">
                            Name:
                            <input type="text" name="name" required  class="center outline_color_dark_blue" placeholder="Your name...">
                            E-mail:
                            <input type="email" name="email" required class="center outline_color_dark_blue" placeholder="Your e-mail...">
                            Subject:
                            <input type="text" name="subject" required class="center outline_color_dark_blue" placeholder="Reason for ...">
                            Message:
                            <textarea rows="8" type="text" name="message" required class="center expandable_textbox outline_color_dark_blue" placeholder="Your message..." size="50"></textarea><br><br>
                            <div id="recaptcha">
                                <div id="recaptcha" class="g-recaptcha" data-callback="recaptchacallback" data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
                            </div><br>
                            <button class="btn disabled waves-effect waves-light dark_blue_color_backround btn" type="submit" id="submit_button" name="submit">Send</button>
                            <button class="btn waves-effect waves-light dark_blue_color_backround btn" type="reset">Reset</button>
                        </form>
                        </b>
                    </a>
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

</body>
</html>
