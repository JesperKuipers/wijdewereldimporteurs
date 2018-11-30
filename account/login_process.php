<?php
session_start();
//include '../functions.php';
include '../database_connectie.php';
include '../index.php';

$db = db_connect();
$stmt = $db->prepare('SELECT * FROM registered_users WHERE email=:email');
$stmt->execute(array(':email' => $email));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['loginbutton'])) {
    if($stmt->rowCount() > 0) {
        if(password_verify($password, $row['password'])) {
            session_regenerate_id();
            $_SESSION["authorised"] = TRUE;
            $_SESSION["email"] = $row['email'];
            $_SESSION["password"] = $row['password'];
            session_write_close();
            header('location: index.html');
        }
        
    }
}
