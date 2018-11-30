
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
    <li>
    </li>
    <p><b> </b></p>
    <?php
    //$customerid = $_SESSION["customerID"];
    $db = db_connect();
    $stmt = $db->prepare("SELECT o.OrderID, SUM(ol.Quantity*s.RecommendedRetailPrice) total, OrderDate, Description, customerid
FROM orders o 
JOIN orderlines ol
ON o.orderid = ol.orderid
JOIN stockitems s
ON s.stockitemid = ol.stockitemid

GROUP BY OrderID
HAVING customerID = 2
ORDER BY OrderDate");
    $stmt->bindparam()
    $totalprice = [total];
    $totalquantity = 0;
    foreach ($stmt as $orders) {
    foreach ($orders as $order) {
    $totalprice = $totalprice + ($order['RecommendedRetailPrice'] * $orders['Quantity']); ?>
    <span class="title">
   <p <?= $order['OrderID'] ?> <?= $item['QuantityOnHand'] ?> </p>
    <p class="secondary-content" style="text-align: left">
        Price: &euro; <?= $totalprice ?><br/>
        Quantity: <input class="browser-default"
                         onchange="changequantity(this.value, <?= $item['StockItemID'] ?>)"
                         type="number" value="<?= $items['item_quantity'] ?>"/>
    </p>

    ?>
    <th>Order</th>
    <td><?= $stmt['OrderID' . 'total' . 'OrderDate' . 'Description'] ?></td>

</div>


    <?php footer() ?>

</body>
</html>
