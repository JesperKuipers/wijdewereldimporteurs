<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php";
    require '../database_connectie.php'; ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>
<?php navbar() ?>
<div class="container center content">

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $pdo = db_connect();
        $customerid = $_SESSION['customerid'];
        $stmt = $pdo->prepare("SELECT oc.orderId, SUM(so.quantity*si.RecommendedRetailPrice) total, oc.receivedate, GROUP_CONCAT(si.stockitemname SEPARATOR ',') as stockitemname, ru.customerid
FROM orderbycustomers oc 
JOIN registered_users ru 
ON oc.customerid = ru.customerid 
JOIN stockitemorders so 
ON oc.orderId = so.orderId 
JOIN stockitems si 
ON so.StockItemID = si.StockItemID
WHERE oc.customerid = $customerid
GROUP BY oc.orderId
ORDER BY oc.receivedate");
        $stmt->execute();
        $customerinfo = $stmt->fetchAll();
        ?>

    <table style="width:100%">
        <tr>
            <th>Order</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Products</th>
        </tr>
        <?php foreach ($customerinfo as $info) { ?>

        <tr>
            <td><?php echo $info['orderId']; ?></td>
            <td><?php echo $info['total']; ?></td>
            <td><?php echo $info['receivedate']; ?></td>
            <td><?php
                $array = explode(',', $info['stockitemname']);
                foreach ($array as $var) {
                    echo $var . '<br/>';
                }
                ?></td>
        </tr>


        <?php } ?>
    </table>
        <form action="../account/account.php">
            <button type="submit" class="changeaccountbtn s12 btn btn-small waves-effect">Back to account
            </button>
        </form>
    <?php } else {
        print("<h3 align='center'>You need to be logged in to see this page.</h3>");
    }
    ?>

</div>


<?php footer() ?>

</body>
</html>

