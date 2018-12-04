<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>
</head>
<?php
$hostname = $_SERVER['HTTP_HOST'];
$protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    require_once '../vendor/autoload.php';
    require_once '../query.php';
    try {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_3NDNxnAAgMNzHTv4u9BQkdpR5udhh8");

        if (isset($_POST['pay'])) {
            $orderId = time();
            $payment = $mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $_POST['amount']
                ],
                "description" => "Payment customer",
                "redirectUrl" => "{$protocol}://{$hostname}/paymentreturn.php?order_id={$orderId}",
                "metadata" => [
                    "order_id" => $orderId,
                ]
            ]);
            database_write($orderId, $payment->id, $payment->status);
            header("Location: " . $payment->getCheckoutUrl(), true, 303);

        }
    } catch (\Mollie\Api\Exceptions\ApiException $e) {
        throw new Exception("API call failed: " . htmlspecialchars($e->getMessage()), $e->getCode(), $e->getPrevious());
    }
    ?>

    <body>

    <!--Import navbar-->
    <?php navbar() ?>

    <!--|-----------BEGINNING---------------------------|
        |----------Catergories--------------------------|
        |-----------------------------------------------|-->
    <?php
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    $cookieResults = array();
    foreach ($cart_data as $value) {
        array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
    }
    ?>
    <div class="container">
        <h2>Afrekenen</h2>
        <form method="post">
            <div class="row">
                <ul class="collection">
                    <?php
                    $totalprice = 0;
                    $totalquantity = 0;
                    foreach ($cookieResults as $items) {
                        foreach ($items as $item) {
                            if (isset($item['StockItemName'])) {
                                $totalprice = $totalprice + ($item['RecommendedRetailPrice'] * $items['item_quantity']);
                                $totalquantity = $totalquantity + $items['item_quantity'];
                                ?>
                                <li class="collection-item avatar">
                                    <img src="/images/no-image.jpg" alt="" class="circle">
                                    <span class="title"><?= $item['StockItemName'] ?></span>
                                    <p class="secondary-content" style="text-align: left">
                                        Price: &euro; <?= $item['RecommendedRetailPrice'] ?><br/>
                                        Quantity: <?= $items['item_quantity'] ?>
                                    </p>
                                </li>
                            <?php }
                        }
                    }
                    if (isset($totalquantity) && isset($totalprice) && $totalquantity != 0 && $totalprice != 0) { ?>
                        <li class="collection-item avatar" style="text-align: left;">
                            <p>Total quantity<br/>Subtotal</p>
                            <div class="secondary-content">
                                <?= $totalquantity ?><br/>
                                &euro; <?= $totalprice ?>
                                <input type="hidden" name="amount" value="<?= round($totalprice, 2)?>">
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="row">
                <button class="btn waves-effect waves-light blue darken-1" style="float: right;" name="pay" type="submit">Afrekenen
                </button>
            </div>
        </form>
    </div>
    <!--|--------------END------------------------------|
        |-----------Catergories-------------------------|
        |-----------------------------------------------|-->


    <!--Import footer-->
    <?php footer() ?>

    </body>
    </html>

    <?php
} else {
    header('Location: /account/if_not_logged_in.php');
}

