<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "functions.php";
    include 'database_connectie.php';?>
    
    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->


<!-- class="content" is nodig voor sticky footer -->
<div class="container-changeaccount center content">
    <form method="POST">
        <h4>Change your account settings</h4><br>
        <h7><b>First name:</b></h7><br>
            <input type="text" name="fname" id="fname" class="changeaccountinput" value=" <?php
            $pdo = db_connect();
            $customerid = $_SESSION['customerid'];
            $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
            $stmt->execute();
            $resultfname = $stmt->fetch();
            echo $resultfname['first_name'];
            ?>"><br>
        <h7><b>Last name:</b></h7><br>
            <input type="text" name="lname" id="lname" class="changeaccountinput" value="<?php
            $pdo = db_connect();
            $customerid = $_SESSION['customerid'];
            $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
            $stmt->execute();
            $resultlname = $stmt->fetch();
            echo $resultfname['last_name'];
            ?>"><br>
        <!--<h7><b>E-mail:</b></h7><br>
            <input type="email" name="email" id="email" class="changeaccountinput" value="<?php// print($_SESSION['email']);?>" required><br>-->
        <h7><b>Password:</b></h7><br>
            <input type="password" name="password" id="password" class="changeaccountinput" value=<?php
            $pdo = db_connect();
            $customerid = $_SESSION['customerid'];
            $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
            $stmt->execute();
            $resultpassword = $stmt->fetch();
            echo $resultpassword['password'];
            ?>" required><br>
        <h7><b>Address:</b></h7><br>
            <input type="text" name="address" id="address" class="changeaccountinput" value="<?php
        $pdo = db_connect();
        $customerid = $_SESSION['customerid'];
        $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
        $stmt->execute();
        $resuladdress = $stmt->fetch();
        echo $resuladdress['address'];
        ?>" required><br>
        <h7><b>Postal Code:</b></h7><br>
            <input type="text" name="postalcode" id="postalcode" class="changeaccountinput" value="<?php
            $pdo = db_connect();
            $customerid = $_SESSION['customerid'];
            $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
            $stmt->execute();
            $resulpostalcode = $stmt->fetch();
            echo $resulpostalcode['postal_code'];
            ?>" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="1234 AB"" required><br>
        <button type="submit" name="updateaccountbtn" class="btnupdateaccount s12 btn btn-large waves-effect">Update account</button>
    </form>
    <form action="account.php">
    <button type="submit" name="accountbtn" class="btnreturnaccount s12 btn btn-large waves-effect">Return to account</button>
    </form>
</div>

<?php

if(isset($_POST['updateaccountbtn'])){
    
    $pdo = db_connect();
    
    if(!preg_match('#[1-9][0-9]{3}\s?[a-zA-Z]{2}+#', $_POST['postalcode'])) {
        die("<script type='text/javascript'>alert('Your postal code is incorrect')</script>");
    }
    
    $customerid = $_SESSION['customerid'];
    $fname = !empty($_POST['fname']) ? trim($_POST['fname']) : null;
    $lname = !empty($_POST['lname']) ? trim($_POST['lname']) : null;
    //$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $address = !empty($_POST['address']) ? trim($_POST['address']) : null;
    $postalcode = !empty($_POST['postalcode']) ? trim($_POST['postalcode']) : null;
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
    //$sql = "SELECT COUNT(email) AS cus FROM registered_users WHERE email = :email";
    //$stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    //$stmt->bindValue(':email', $email);
    
    //Execute.
    //$stmt->execute();
    
    //Fetch the row.
    //$row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided username already exists - display error.
    //TO ADD - Your own method of handling this error. For example purposes,
    //I'm just going to kill the script completely, as error handling is outside
    //the scope of this tutorial.
    //if($row['cus'] > 0){
    //    die("<script type='text/javascript'>alert('That E-mail already exists')</script>");
    //}
    
    //Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    
    $sql = "UPDATE registered_users
    SET first_name = :fname, last_name = :lname, password = :password, address = :address, postal_code = :postalcode
    WHERE customerid = $customerid";
    
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    //$stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':postalcode', $postalcode);
    
    //Execute the statement and insert the new account.
    $result = $stmt->execute();
}

?>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>
