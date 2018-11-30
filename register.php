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

<?php
$pdo = db_connect();
$customerid = 1;
$st = $pdo->prepare("SELECT MAX(customerid) as customerid FROM registered_users");
$st->execute();
$resultid = $st->fetch();
$customerid = $resultid['customerid'];

if(isset($_POST['registerbutton'])) {
    
    if(!preg_match('#[1-9][0-9]{3}\s?[a-zA-Z]{2}+#', $_POST['postalcode'])) {
        die("<script type='text/javascript'>alert('Je postcode is kut')</script>");
    }
    $customerid++;
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
    if($row['cus'] > 0) {
        die("<script type='text/javascript'>alert('That E-mail already exists')</script>");
    }
    
    //Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    
    $sql = "INSERT INTO registered_users (customerid, first_name, last_name, email, password, address, postal_code)
    VALUES (:customerid, :fname,:lname, :email, :password, :address, :postalcode)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':customerid', $customerid);
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':postalcode', $postalcode);
    
    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result) {
        echo "<script type='text/javascript'>alert('You have succesfully registered');
    window.location.href = \"/inlog.php\";
    </script>";
    
    }
    
}

?>

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