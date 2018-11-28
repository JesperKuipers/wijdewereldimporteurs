<?php

require '../query.php';

// Check if cookie allready exists, if true, fill array with cookie data, if false create a empty array
if (isset($_COOKIE["shopping_cart"])) {
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
} else {
    $cart_data = array();
}


// All id's from products
$item_id_list = array_column($cart_data, 'item_id');

if (isset($_POST['id'])) {
// if the cookie already has this id? If true set quantity + 1. if not, create a new array from the post values
    if (in_array($_POST["id"], $item_id_list)) {
        foreach ($cart_data as $keys => $values) {
            if ($cart_data[$keys]["item_id"] == $_POST["id"]) {
                $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + 1;
            }
        }
    } else {
        $item_array = array(
            'item_id' => $_POST["id"],
            'item_quantity' => 1
        );
        $cart_data[] = $item_array;
    }

    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 7), "/");

    header('Location: /products/detail.php?itemId=' . $_POST['id'] . '&cookie=set');
}

if (isset($_POST['changequantity']) && isset($_POST['changequantityid']) && in_array($_POST['changequantityid'], $item_id_list)) {
    foreach ($cart_data as $keys => $values) {
        if ($cart_data[$keys]["item_id"] == $_POST['changequantityid'] && getByItemId($_POST['changequantityid'])['QuantityOnHand'] >= $_POST['changequantity'] && intval($_POST['changequantity']) > 0) {
            $cart_data[$keys]["item_quantity"] = $_POST['changequantity'];
        } else {
            echo 'false';
        }
    }
    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 7), "/");

    echo 'true';
}

if (isset($_POST['removeproduct'])) {
    foreach($cart_data as $keys => $values) {
        if($cart_data[$keys]['item_id'] == $_POST['removeproduct']) {
            unset($cart_data[$keys]);
            $item_data = json_encode($cart_data);
            setcookie('shopping_cart', $item_data, time() + (86400 * 7), "/");
            echo "true";
        }
    }
}