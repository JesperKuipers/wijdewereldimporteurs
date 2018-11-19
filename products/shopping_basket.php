<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>
    <script>
        function changequantity(quantity, id) {
            $.post("/products/addToShoppingBasket.php", {changequantity: quantity, changequantityid: id})
                .success(setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 500));
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
<div class="center content">
    <?php
    include '../query.php';
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    $cookieResults = array();
    foreach ($cart_data as $value) {
        array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
    }
    ?>
    <div class="container">
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
                            <p>Stock: <?= $item['QuantityOnHand'] ?></p>
                            <p class="secondary-content">
                                Price: &euro; <?= $item['RecommendedRetailPrice'] ?><br/>
                                Quantity: <input class="browser-default"
                                                 onchange="changequantity(this.value, <?= $item['StockItemID'] ?>)"
                                                 type="number" value="<?= $items['item_quantity'] ?>"/>
                            </p>
                        </li>
                    <?php }
                }
            } ?>
            <li class="collection-item avatar" style="text-align: left;">
                <p>Total quantity<br/>Subtotal</p>
                <div class="secondary-content">
                    <?= $totalquantity ?><br/>
                    &euro; <?= $totalprice ?>
                </div>
            </li>
        </ul>
    </div>
</div>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>
