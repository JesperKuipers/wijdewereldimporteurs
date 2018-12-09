<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php";
    require '../database_connectie.php';?>
    <!--Import basic imports-->
    <?php imports() ?>

</head>
<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//getting customer information
$pdo = db_connect();
$customerid = $_SESSION['customerid'];
$stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
$stmt->execute();
$customerinfo = $stmt->fetch();?>

<!-- class="content" is needed for sticky footer -->
<div class="container-changeaccount center content">
    <form method="POST">
        <h4>Change your account settings</h4><br>
        <h7><b>First name:</b></h7><br>
            <input type="text" name="fname" id="fname" class="changeaccountinput" value="<?php echo $customerinfo['first_name'];?>"><br>
        <h7><b>Last name:</b></h7><br>
            <input type="text" name="lname" id="lname" class="changeaccountinput" value="<?php echo $customerinfo['last_name'];?>"><br>
        <h7><b>E-mail:</b></h7><br>
            <input type="email" name="email" id="email" class="changeaccountinput" value="<?php echo $customerinfo['email'];?>" required><br>
        <h7><b>Address:</b></h7><br>
            <input type="text" name="address" id="address" class="changeaccountinput" value="<?php echo $customerinfo['address'];?>" required><br>
        <h7><b>Postal Code:</b></h7><br>
            <input type="text" name="postalcode" id="postalcode" class="changeaccountinput" value="<?php echo $customerinfo['postal_code'];?>"
                   pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="1234 AB" required><br>
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
    $fname = !empty($_POST['fname']) ? filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING) : null;
    $lname = !empty($_POST['lname']) ? filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING) : null;
    $email = !empty($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : null;
    $address = !empty($_POST['address']) ? filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) : null;
    $postalcode = !empty($_POST['postalcode']) ? filter_input(INPUT_POST, 'postalcode', FILTER_SANITIZE_STRING) : null;
    
    //Check if the supplied email already exists.
    
    if($email != $customerinfo['email']){
    
        //Construct the SQL statement and prepare it.
        $sql = "SELECT COUNT(email) AS cus FROM registered_users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
    
        //Bind the provided email to our prepared statement and execute it
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    
        //Fetch the row.
        $row = $stmt->fetch();
    
        //If the provided email already exists - display error.
        if($row['cus'] > 0){
            die("<script type='text/javascript'>alert('That E-mail already exists')</script>");
        }
    }
    
    //Prepare the update statement.
    $sql = "UPDATE registered_users
    SET first_name = :fname, last_name = :lname, email = :email, address = :address, postal_code = :postalcode
    WHERE customerid = $customerid";
    
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':postalcode', $postalcode);
    
    //Execute the statement and update the account.
    $result = $stmt->execute();
    ?>
    <script type='text/javascript'>alert('You have updated your account information');
    window.location.href = "/account/account.php";
    </script>
    <?php
}

}else{
    ?>
    <div class="notloggedin center content">
    <h3>You need to be logged in to see this page.</h3>
    </div>
<?php
}
?>

<!--Import footer-->
<?php footer() ?>

</body>
</html>