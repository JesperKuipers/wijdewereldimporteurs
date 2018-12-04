<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->


<!-- class="content" is nodig voor sticky footer -->
<div class="center content">

    <?php
    require '../query.php';
    require_once '../vendor/autoload.php';

    try {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_3NDNxnAAgMNzHTv4u9BQkdpR5udhh8");
        $data = database_read($_GET['order_id']);
        $payment = $mollie->payments->get($data['paymentid']);
        $orderId = $payment->metadata->order_id;

        /*
         * Update the order in the database.
         */
        database_write($orderId, $payment->id, $payment->status);
        if ($payment->isPaid()) {
            echo "<p>Your payment was successfull</p>";
            setcookie("shopping_cart", "", time() - 3600);
        } else {
            echo "<p>Your payment is failed! <br/>Your payment status is '" . htmlspecialchars($payment->status) . "'.</p>";
        }
    } catch (\Mollie\Api\Exceptions\ApiException $e) {
        throw new Exception("API call failed: " . htmlspecialchars($e->getMessage()), $e->getCode(), $e->getPrevious());
    }
    ?>
</div>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>
