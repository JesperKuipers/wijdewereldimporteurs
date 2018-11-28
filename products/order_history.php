
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
    <p><b>insert </b></p>
    <?php $db = db_connect();
    $stmt = $db->prepare("SELECT o.OrderID, SUM(ol.Quantity*ol.UnitPrice), OrderDate, Description, customerid
FROM orders o JOIN orderlines ol
ON o.orderid = ol.orderid
GROUP BY OrderID
HAVING customerID = 2")
    ?>


</div>


    <?php footer() ?>

</body>
</html>
