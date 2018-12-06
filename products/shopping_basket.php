<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>
    <script>
        function changequantity(quantity, id) {
            $.ajax({
                type: "POST",
                url: "/products/shoppingbasketcookie.php",
                data: {
                    changequantity: quantity,
                    changequantityid: id
                },
                success: function (response) {
                    console.log(response);
                    if (response == 'true') {
                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 500);
                    } else {
                        alert('We don\'t have that in stock or you entered a negative number');
                        location.reload();
                    }

                }
            })
        }

        function removeproduct(id) {
            $.ajax({
                type: "POST",
                url: "/products/shoppingbasketcookie.php",
                data: {
                    removeproduct: id
                },
                success: function (response) {
                    if (response == 'true') {
                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 500);
                    } else {
                        alert('Removing the product has failed');
                    }

                }
            })
        }
    </script>
</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->


<!-- class="content" is nodig voor sticky footer -->
<form class="center content" method="POST" action="payment.php">
    <?php
    include '../query.php';
    if (isset($_COOKIE['shopping_cart'])) {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        $cookieResults = array();
        foreach ($cart_data as $value) {
            array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
        }

    ?>
    <div class="container">
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
                                <input type="hidden" name="ids[]" value="<?= $item['StockItemID'] ?>"/>
                                <img src="/images%20(temp)/no-image.jpg" alt="" class="circle">
                                <span class="title"><?= $item['StockItemName'] ?></span>
                                <p>Stock: <?= $item['QuantityOnHand'] ?></p>
                                <p class="secondary-content" style="text-align: left">
                                    Price: &euro; <?= $item['RecommendedRetailPrice'] ?><br/>
                                    Quantity: <input class="browser-default"
                                                     onchange="changequantity(this.value, <?= $item['StockItemID'] ?>)"
                                                     type="number" value="<?= $items['item_quantity'] ?>"/>
                                    <i class="material-icons" style="cursor: pointer"
                                       onclick="removeproduct(<?= $item['StockItemID'] ?>)">remove_shopping_cart</i>
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
                        &euro; <?= number_format($totalprice, 2, ',', '.') ?>
                    </div>
                </li>
                <?php } else {
                    echo '<li class="collection-item"><h2>Shopping cart is empty</h2></li>';
                }?>
            </ul>
        </div>
        <?php if (isset($totalquantity) && isset($totalprice) && $totalquantity != 0 && $totalprice != 0) { ?>
        <div class="row">
            <button class="btn waves-effect waves-light blue darken-1" style="float: right;" type="submit">Order
            </button>
        </div>
        <?php } ?>

    </div>
    <?php } else {
        echo '<h2>Shopping cart is empty</h2>';
    }?>
</form>
<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>
