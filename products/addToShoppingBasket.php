<?php
// Kijken of de cookie al geset is, zo ja, vul dan de array hiermee, zo nee, maak een lege array
if (isset($_COOKIE["shopping_cart"])) {
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
} else {
    $cart_data = array();
}

// Alle id's van de producten staan in deze variabele
$item_id_list = array_column($cart_data, 'item_id');

if (isset($_POST['id'])) {
//Staat de id uit de post in deze array? Zo ja: zet dan de quantity 1tje hoger,
// Zo nee, maak een nieuwe array aan met de nieuwe post waarden
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
        if ($cart_data[$keys]["item_id"] == $_POST['changequantityid']) {
            $cart_data[$keys]["item_quantity"] = $_POST['changequantity'];
        }
    }
    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 7), "/");
}