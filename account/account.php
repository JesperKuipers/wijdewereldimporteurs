<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require '../functions.php';
    require '../database_connectie.php';
    imports() ?>

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
    $customerinfo = $stmt->fetch();
    ?>

    <div class="container-account center content">
        <p><h5>You are currently logged in as <?php print $customerinfo['first_name'] . " " . $customerinfo['last_name'] ?></h5></p>
        <form method="post">
            <button type="submit" name="logoutbtn" class="logoutbtn s12 btn btn-large waves-effect">Log Out</button>
        </form>
    </div>
    <div class="container-accountinfo left content">
        <b>First name</b><br>
        <?php echo $customerinfo['first_name']; ?><br>
        <b>Last name</b><br>
        <?php echo $customerinfo['last_name']; ?><br>
        <b>E-mail</b><br>
        <?php echo $customerinfo['email']; ?><br>
        <b>Address</b><br>
        <?php echo $customerinfo['address']; ?><br>
        <b>Postal Code</b><br>
        <?php echo $customerinfo['postal_code']; ?><br>
        <form action="accountchange.php">
            <button type="submit" class="changeaccountbtn s12 btn btn-small waves-effect">Change account settings
            </button>
        </form>
    </div>
    <?php
    if(isset($_POST['logoutbtn'])) {
        if(isset($_SESSION['loggedin'])) {
            unset($_SESSION['loggedin']);
        }
        session_destroy();
        header('refresh : 0; url=../index.php');
    }
} else{
    ?>
    <div class="notloggedin center content">
        <h3>You need to be logged in to see this page.</h3>
    </div>
    <?php
}
?>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>