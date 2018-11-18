<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

    <?php if (isset($_GET['cookie']) && $_GET['cookie'] == 'set') { ?>
        <script>
            $(function () {
                //initialize all modals
                $('.modal').modal();

                //now you can open modal from code
                $('.modal').modal('open');
            })
        </script>
    <?php } ?>
</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <?php
    include '../Query.php';

    $result = getByItemId($_GET['itemId']);
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    $cookieResults = array();
    foreach ($cart_data as $value) {
        array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
    }

    if (isset($result['CustomFields'])) {
        $customFields = explode(':', $result['CustomFields'])[1];
        $CountryOfManufacture = explode(',', $customFields)[0];
    }
    ?>
    <div class="row">
        <div class="col s14 m6">
            <img src="/images/no-image.jpg" width="500"/>
        </div>
        <div class="col s14 m6">
            <form method="POST" action="addToShoppingBasket.php">
                <input type="hidden" name="id" value="<?= $result['StockItemID'] ?>">
                <h4>Product information</h4>
                <table class="responsive-table">
                    <tr>
                        <th>Product name</th>
                        <td><?= $result['StockItemName'] ?></td>
                    </tr>
                    <?php if ($result['Size']) {
                        ?>
                        <tr>
                            <th>Size</th>
                            <td><?= $result['Size'] ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (isset($CountryOfManufacture)) { ?>
                        <tr>
                            <th>Made In</th>
                            <td><?= str_replace('"', '', $CountryOfManufacture) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($result['MarketingComments']) {
                        ?>
                        <tr>
                            <th>Extra Information</th>
                            <td><?= $result['MarketingComments'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Price</th>
                        <td> &euro; <?= $result['RecommendedRetailPrice'] ?></td>
                    </tr>
                    <?php if ($result['ColorName']) { ?>
                        <tr>
                            <th>Colour</th>
                            <td><?= $result['ColorName'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Stock</th>
                        <td><?= $result['QuantityOnHand'] ?></td>
                    </tr>
                </table>
                <br/>
                <button class="btn-small waves-effect waves-light blue darken-1" style="float: right" type="submit">In
                    winkelmandje plaatsen
                </button>
                <div class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Winkelwagentje</h4>
                        <ul class="collection">
                            <?php
                            $totalprice = 1;
                            foreach ($cookieResults as $values) {
                                foreach ($values as $value) {
                                    if ($value['StockItemName']) {
                                        $totalprice = $totalprice + ($value['RecommendedRetailPrice'] * $values['item_quantity']);
                                        ?>
                                        <li class="collection-item avatar">
                                            <img src="/images/no-image.jpg" alt="" class="circle">
                                            <span class="title"><?= $value['StockItemName'] ?></span>
                                            <p>Stock: <?= $value['QuantityOnHand'] ?></p>
                                            <p class="secondary-content">
                                                Price: &euro; <?= $value['RecommendedRetailPrice'] ?><br/>
                                                Quantity: <?= $values['item_quantity'] ?>
                                            </p>

                                        </li>
                                    <?php }
                                }
                            } ?>
                            <li class="collection-item">
                                <span class="title">Subtotal</span>
                                <div class="secondary-content">
                                    &euro; <?= $totalprice ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="/products/detail.php?itemId=<?= $_GET['itemId'] ?>" class="modal-close waves-effect waves-green btn-flat">Verder winkelen</a>
                        <a href="/products/winkelmandje.php" class="modal-close waves-effect waves-green btn-flat">Ga naar winkelwagentje</a>
                    </div>
                </div>
        </div>
    </div>
</div>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>