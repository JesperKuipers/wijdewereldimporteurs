<?php

function email($name, $subject, $mailfrom, $message)
{
    $mailto = 'contact@wijdewereldimporteurs.nl';
    $headers = "From: " . $mailfrom;
    $txt = "You have received an e-mail from " . $name . ". \n\n" . $message;

    mail($mailto, $subject, $txt, $headers);
}

$fname=filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname=filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
$email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$address=filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$postalcode=filter_input(INPUT_POST, 'postalcode', FILTER_SANITIZE_STRING);

function passwordcheck($password,$repassword){
    if($password != $repassword){
        Print("The password is not the same");
    }
}


function imports () {
    ?>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="/css/main.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Start session, temp saves stuff-->
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <?php session_start()?>

    <?php
}

function navbar()
{
    ?>
<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!--|-------Nav-bar-en-rechter-icons----------------|-->
    <nav>
        <div class="nav-wrapper blue-grey darken-3">
            <a href="/index.php" class="brand-logo center"><i><img src="/images%20(temp)/wwi-logo.png" width="70%"
                                                                   alt="Image"></i></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <li><a href="/account/account.php"><i class="material-icons">person</i></a></li>
                <?php } else { ?>
                    <li><a href="/account/inlog.php"><i class="material-icons">person</i></a></li>
                <?php } ?>
                <li><a href="/products/shopping_basket.php"><i class="material-icons">shopping_basket</i></a></li>
            </ul>

            <!--|---------------Search-bar----------------------|-->
            <form id="spatieSearchBar" method="POST" action="/searchbar.php">
                <div class="input-field center searchDiv">
                    <input id="search" name="search" type="search" placeholder="Search..." class="searchbar" required>
                    <label class="label-icon material-icons" for="search"><i>search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>

            <!--|--------------Mobile-menu----------------------|-->
        </div>
    </nav>
    <ul class="sidenav" id="mobile-demo">
        <li><a href="/account/inlog.php"><i class="material-icons">person</i></a></li>
        <li><a href="/products/shopping_basket.php"><i class="material-icons">shopping_basket</i></a></li>
    </ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->
    <?php
}

function footer()
{
    ?>
<!--|-----------BEGINNING---------------------------|
    |------------Footer-----------------------------|
    |-----------------------------------------------|-->


    <footer class="page-footer blue-grey darken-3 sticky-footer">
        <div class="container">
            <div class="row center">

            <a class="light_blue_color" href="/about_wwi.php">About WWI</a>
            <a class="light_blue_color dubbele_spatie" href="/index.php">Home page</a>
            <a class="light_blue_color dubbele_spatie smooth-goto" href="/about_wwi.php#scroll">Contact WWI</a>

            </div>
        </div>
        <div class="footer-copyright">
            <div class="container center">
                <a class="light_blue_color">&copy; 2018. Wide World Importers. All Rights Reserverd. <br> Designed by
                    ICTM1l Group 3</p></a>
            </div>
        </div>
    </footer>

<!--|--------------END------------------------------|
    |-------------Footer----------------------------|
    |-----------------------------------------------|-->

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php

}

