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
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php include 'functions.php';
    include 'database_connectie.php';
    session_start();;?>
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
    <!--todo: search balk hierin -->
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<div class="container-register center content">
    <h1><b class="createwwi">Create your WWI account</b></h1>
    <p class="required">* Required Field</p>
    <form method="POST" class="registerinput">
        <div class="required"><br></div>
        <b>First name: </b><input type="text" name="fname" id="fname" class="rinputs" style="margin-left: 41px"><br>
        <b>Last name: </b><input type="text" name="lname" id="lname" class="rinputs" style="margin-left: 43px"><br>
        <b>E-Mail: </b><input type="email" name="email" id="email" class="rinputs" required style="margin-left: 75px">
            <span class="required">*</span><br>
        <b>Password: </b><input type="password" name="password" id="password" class="rinputs" required style="margin-left: 55px">
            <span class="required">*</span><br>
        <b>Address: </b><input type="text" name="address" id="address" class="rinputs" required style="margin-left: 63px">
            <span class="required">*</span><br>
        <b>Postal Code: </b><input type="text" name="postalcode" id="postalcode" class="rinputs" required style="margin-left: 39px">
            <span class="required">*</span><br><br>
        <div id="recaptcha">
            <div class="g-recaptcha" data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
        </div>
        <button type="submit" name="registerbutton" id="submitBtn" class="btnregister s12 btn btn-large waves-effect">Register</button>
    </form>
    <div>
        <label class="alreadyaccount" >
            <br>Already have an account?<br>
            <a class="loginhere" href="inlog.php"><b><u>Log in here</u></b></a>
        </label>
    </div>
</div>

<?php

if(isset($_POST['registerbutton'])){
    
    $pdo = db_connect();
    
    $fname = !empty($_POST['fname']) ? trim($_POST['fname']) : null;
    $lname = !empty($_POST['lname']) ? trim($_POST['lname']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $address = !empty($_POST['address']) ? trim($_POST['address']) : null;
    $postalcode = !empty($_POST['postalcode']) ? trim($_POST['postalcode']) : null;
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(email) AS cus FROM registered_users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':email', $email);
    
    //Execute.
    $stmt->execute();
    
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided username already exists - display error.
    //TO ADD - Your own method of handling this error. For example purposes,
    //I'm just going to kill the script completely, as error handling is outside
    //the scope of this tutorial.
    if($row['cus'] > 0){
        die('That username already exists!');
    }
    
    //Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    
    $sql = "INSERT INTO registered_users (first_name, last_name, email, password, address, postal_code)
    VALUES (:fname,:lname, :email, :password, :address, :postalcode)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':postalcode', $postalcode);
    
    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        echo "<script type='text/javascript'>alert('Successfully registered!')</script>";
    }
    
}

?>

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
                3</php></a>
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