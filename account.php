<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "functions.php";
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
    <p><b>You are currently logged in as <?php print($_SESSION['first_name'] . " " . $_SESSION['last_name'])?></b></p>
    <form method="post">
        <button type="submit" name="logoutbtn" class="logoutbtn s12 btn btn-large waves-effect">Log Out</button>
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