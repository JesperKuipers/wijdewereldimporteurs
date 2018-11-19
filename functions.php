<?php

$fname=filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname=filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
$email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$address=filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$postalcode=filter_input(INPUT_POST, 'postalcode', FILTER_SANITIZE_STRING);

function passwordcheck($password,$repassword){
    if($password != $repassword){
        Print("The password is not the same");
    }
}
