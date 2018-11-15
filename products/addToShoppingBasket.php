<?php

$cookie = $_COOKIE['itemCookie'] ?? "";
$cookie = stripslashes($cookie);
$savedCartItems = json_decode($cookie, true);

if (empty($savedCartItems)) {
    $savedCartItems = array();
}

if (!empty($savedCartItems) > 0 && array_key_exists($_POST['id'], $savedCartItems)) {
    foreach ($savedCartItems as $key => $value) {
        $cartItems[$_POST['id']] = ['count' => $value['count'] + 1];
    }
} elseif (!empty($savedCartItems) > 0 && !array_key_exists($_POST['id'], $savedCartItems)) {
    foreach ($savedCartItems as $key => $value) {
        $cartItems[$_POST['id']][] = ['count' => 1];
    }
} else {
    $cartItems[$_POST['id']] = array(
        'count' => 1
    );
}

var_dump($cartItems);
$json = json_encode($cartItems, true);
setcookie("itemCookie", $json, time() + 86400, "/");

//header('Location: shoppingBasketOrFurther.php');

