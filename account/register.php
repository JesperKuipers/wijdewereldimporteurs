<?php

if (isset($_POST['submit'])) {
    include '.php/functions.php';
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
    <?php include "../.php/functions.php" ?>
    <!--Import basic imports-->
    <?php imports() ?>
</head>

<body>

    <!--Import navbar-->
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
        <b>Password: </b><input type="password" name="password" id="password" class="rinputs" required style="margin-left: 55px">
            <span class="required">*</span><br>
        <b>Address: </b><input type="text" name="address" id="address" class="rinputs" required style="margin-left: 63px">
            <span class="required">*</span><br>
        <b>Postal Code: </b><input type="text" name="postalcode" id="postalcode" class="rinputs" required style="margin-left: 39px">
            <span class="required">*</span><br><br>
        <div id="recaptcha" class="g-recaptcha" data-callback="recaptchacallback" data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
        <button type="submit" name="registerbutton" id="submit_button" class="btnregister s12 btn disabled btn-large waves-effect">Register</button>
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
    
    //Check if the supplied username already exists.
    
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
    if($row['cus'] > 0){
        die('That username already exists!');
    }
    
    //Hash the passwords
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
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
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>
    <!--Import reCaptha V2-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!--Include functions.js-->
    <script type="text/javascript" src="/.js/functions.js"></script>

</body>
</html>
