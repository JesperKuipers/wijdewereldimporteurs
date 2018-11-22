<!DOCTYPE html>
<html>
<head>
    <?php session_start(); ?>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="css/main.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php include 'database_connectie.php';
    include 'functions.php'; ?>
</head>

<body>

<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!--|-------Nav-bar-en-rechter-icons----------------|-->
<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="index.html" class="brand-logo center"><i><img src="images/wwi-logo.png" width="70%"
                                                               alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <?php if(isset($_SESSION['authorised'])) { ?>
                <li><a href="register.php"><i class="material-icons">person</i></a></li>
            <?php } else { ?>
                <li><a href="index.html"><i class="material-icons">person</i></a></li>
            <?php } ?>
        </ul>

        <!--|---------------Search-bar----------------------|-->
        <form id="spatieSearchBar">
            <div class="input-field center searchDiv">
                <input id="search" type="search" placeholder="Search for products" class="searchbar" required>
                <label class="label-icon material-icons" for="search"><i>search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>

        <!--|--------------Mobile-menu----------------------|-->
    </div>
</nav>
<ul class="sidenav" id="mobile-demo">

    <li><a href="shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
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
        <label style="float: bottom;">
            <a class="forgotpassword" href="passwordforgot.php"><b><u>Forgot Password</u></b></a>
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
                    $_SESSION["authorised"] = TRUE;
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["password"] = $row['password'];
                    session_write_close();
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


<footer class="page-footer blue-grey darken-3 sticky-footer">
    <div class="container">
        <div class="row center">

            <a class="blue_color" href="over%20wwi.html">Over WWI</a>
            <a class="blue_color dubbele_spatie" href="index.html">Home page</a>

        </div>
    </div>
    <div class="footer-copyright">
        <div class="container center">
            <a class="blue_color">&copy; 2018. Wide World Importers. All Rights Reserverd. <br> Designed by ICTM1l Groep
                3</p></a>
        </div>
    </div>
</footer>

<!--|--------------END------------------------------|
    |-------------Footer----------------------------|
    |-----------------------------------------------|-->

<!--JavaScript at end of body for optimized loading-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
        integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>
</body>
</html>