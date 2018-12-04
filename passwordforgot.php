<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="css/main.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!--|-------Nav-bar-en-rechter-icons----------------|-->
<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="index.html" class="brand-logo center"><i><img src="images/wwi-logo.png" width="70%" alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="inlog.php"><i class="material-icons">person</i></a></li>
            <li><a href="shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
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
    <li><a href="inlog.php"><i class="material-icons">person</i></a></li>
    <li><a href="shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!-- class="content" is nodig voor sticky footer -->
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
