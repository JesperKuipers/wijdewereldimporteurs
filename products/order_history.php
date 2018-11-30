
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
    $customerid = $_SESSION["customerID"];
    $db = db_connect();
    $stmt = $db->prepare("SELECT o.OrderID, SUM(ol.Quantity*ol.UnitPrice) total, OrderDate, Description, customerid
FROM orders o 
JOIN orderlines ol
ON o.orderid = ol.orderid
JOIN stockitems s
ON s.stockitemid = ol.stockitemid
GROUP BY OrderID
HAVING customerID = $customerid")

    ?>
    <th>Order</th>
    <td><?= $result['OrderID' . 'total' . 'OrderDate' . 'Description'] ?></td>

</div>


    <?php footer() ?>

</body>
</html>
