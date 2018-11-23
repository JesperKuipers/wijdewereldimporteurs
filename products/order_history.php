
<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php" ;
    require '../database_connectie.php'; ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>
<?php navbar() ?>
<div class="center content">
    <li class="collection-item avatar">
        <img src="/images/no-image.jpg" alt="" class="circle">
        <span class="title"><?= $item['StockItemName'] ?></span>
        <p>Stock: <?= $date['Orderdate'] ?></p>
        <p class="secondary-content">
            Quantity: <input class="browser-default"
                             onchange="changequantity(this.value, <?= $item['StockItemID'] ?>)"
                             type="number" value="<?= $items['item_quantity'] ?>"/>
        </p>
    </li>
    <p><b>insert </b></p>
    <?php $db = db_connect();
    $stmt = $db->prepare("SELECT o.orderid, o.orderdate, o.customerid, ol.orderid, ol.description
    FROM orders o Join orderlines ol
    ON o.orderid = ol.orderid
    GROUP BY ol.orderid
    ORDER BY o.orderdate")
    ?>


</div>


    <?php footer() ?>

</body>
</html>
