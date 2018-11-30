<?php
session_start();

if (isset($_SESSION['authorised']) && $_SESSION['authorised'] == true){
    echo 'wat gaaf';
}

