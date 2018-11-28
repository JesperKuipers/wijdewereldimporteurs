<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "functions.php";
    include 'database_connectie.php';
    imports() ?>

</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->


<!-- class="content" is nodig voor sticky footer -->
<div class="container-account center content">
    <p><h5>You are currently logged in as <?php print($_SESSION['first_name'] . " " . $_SESSION['last_name'])?></h5></p>
    <form method="post">
        <button type="submit" name="logoutbtn" class="logoutbtn s12 btn btn-large waves-effect">Log Out</button>
    </form>
</div>
<div class="container-accountinfo left content">
    <b>First name</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resultfname = $stmt->fetch();
    echo $resultfname['first_name'];
    ?><br>
    
    <b>Last name</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resultlname = $stmt->fetch();
    echo $resultfname['last_name'];
    ?><br>
    
    <b>E-mail</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resultemail = $stmt->fetch();
    echo $resultemail['email'];
    ?><br>
    
    <b>password</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resultpassword = $stmt->fetch();
    echo $resultpassword['password'];
    ?><br>
    
    <b>Address</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resuladdress = $stmt->fetch();
    echo $resuladdress['address'];
    ?><br>
    
    <b>Postal Code</b><br>
    <?php
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE customerid = $customerid");
    $stmt->execute();
    $resulpostalcode = $stmt->fetch();
    echo $resulpostalcode['postal_code'];
    ?><br>
    <form action="accountchange.php">
        <button type="submit" class="changeaccountbtn s12 btn btn-small waves-effect">Change account settings</button>
    </form>
</div>
<?php
    if(isset($_POST['logoutbtn'])){
    if(isset($_SESSION['loggedin'])){
        unset($_SESSION['loggedin']);
    }
    session_destroy();
    header('refresh : 0; url=../index.php');
}
?>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>