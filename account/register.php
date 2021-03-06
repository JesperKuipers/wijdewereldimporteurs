<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php";
    include "../database_connectie.php"?>
    <!--Import basic imports-->
    <?php imports() ?>
</head>

<body>

<!--|-------Nav-bar----------------|-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container center content ">
    <div class="row" style="width: 400px;">

        <div class="card">
            <div class="card-action text center">
                <a class="dark_grey_color">Create your WWI account</a><br>
            </div>
            <div class="card-action left text card_tekst">
                <form method="POST" class="registerinput left">
                    First name: <input type="text" name="fname" id="fname" class="rinputs"><br>
                    Last name: <input type="text" name="lname" id="lname" class="rinputs"><br>
                    E-Mail: <input type="email" name="email" id="email" class="rinputs" required>
                    Password: <input type="password" name="password" id="password" class="rinputs" required>
                    Address: <input type="text" name="address" id="address" class="rinputs" required>
                    Postal Code: <input type="text" name="postalcode" id="postalcode" class="rinputs" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="1234 AB" required>
                    <div id="recaptcha" class="g-recaptcha" data-callback="recaptchacallback"
                         data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
                    <button type="submit" name="registerbutton" id="submit_button"
                            class="btnregister s12 btn disabled btn-large waves-effect">Register
                    </button>
                </form>
                <div>
                    <label class="alreadyaccount">
                        <br>Already have an account?<br>
                        <a class="loginhere dark_blue_color" href="inlog.php"><u>Log in here</u></a>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$pdo = db_connect();
$customerid = 1;
$st = $pdo->prepare("SELECT MAX(customerid) as customerid FROM registered_users");
$st->execute();
$resultid = $st->fetch();
$customerid = $resultid['customerid'];

if (isset($_POST['registerbutton'])) {
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LcBd3oUAAAAABzSR-I4wK4nXxLCM8QixPzt1pOz';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            if (!preg_match('#[1-9][0-9]{3}\s?[a-zA-Z]{2}+#', $_POST['postalcode'])) {
                die("<script type='text/javascript'>alert('Je postcode is kut')</script>");
            }
            $customerid++;
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
            $row = $stmt->fetch();

            //If the provided username already exists - display error.

            if ($row['cus'] > 0) {
                die("<script type='text/javascript'>alert('That E-mail already exists')</script>");
            }

            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

            //Prepare our INSERT statement.
            //Remember: We are inserting a new row into our users table.

            $sql = "INSERT INTO registered_users (customerid, first_name, last_name, email, password, address, postal_code, account)
            VALUES (:customerid, :fname,:lname, :email, :password, :address, :postalcode, 1)";
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
            if ($result) {
                echo "<script type='text/javascript'>alert('You have succesfully registered');
    window.location.href = \"/account/inlog.php\";
    </script>";

            }
        } else {
            die("<script type='text/javascript'>alert('Something went wrong with the reCAPTCHA field')</script>");
        }
    } else {
        die("<script type='text/javascript'>alert('Please select the reCAPTCHA field')</script>");
    }
    
}

?>

<!--Import footer-->
<?php footer() ?>
<!--Import reCaptha V2-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--Include functions.js-->
<script type="text/javascript" src="/js/functions.js"></script>

</body>
</html>
