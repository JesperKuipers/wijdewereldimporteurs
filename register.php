<!DOCTYPE html>
<html>
<head>
    <?php require "functions.php";
    include 'database_connectie.php';
    imports() ?>
</head>

<body>

<!--|-------Nav-bar----------------|-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
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
        <b>Password: </b><input type="password" name="password" id="password" class="rinputs" required
                                style="margin-left: 55px">
        <span class="required">*</span><br>
        <b>Address: </b><input type="text" name="address" id="address" class="rinputs" required
                               style="margin-left: 63px">
        <span class="required">*</span><br>
        <b>Postal Code: </b><input type="text" name="postalcode" id="postalcode" class="rinputs" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="1234 AB" required
                                   style="margin-left: 39px">
        <span class="required">*</span><br><br>
        <div id="recaptcha">
            <div class="g-recaptcha" data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
        </div>
        <button type="submit" name="registerbutton" id="submitBtn" class="btnregister s12 btn btn-large waves-effect">
            Register
        </button>
    </form>
    <div>
        <label class="alreadyaccount">
            <br>Already have an account?<br>
            <a class="loginhere" href="inlog.php"><b><u>Log in here</u></b></a>
        </label>
    </div>
</div>



<!--|-----------BEGINNING---------------------------|
    |------------Footer-----------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

<!--JavaScript at end of body for optimized loading-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
        integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>
</body>
</html>