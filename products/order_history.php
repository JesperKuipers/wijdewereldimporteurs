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
<div class="center content">
    <li>
    </li>
    <p><b> </b></p>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $pdo = db_connect();
    $customerid = $_SESSION['customerid'];
    $stmt = $pdo->prepare("SELECT oc.orderId, SUM(so.quantity*si.RecommendedRetailPrice) total, oc.receivedate, si.stockitemname, ru.customerid
FROM orderbycustomers oc 
JOIN registered_users ru 
ON oc.customerid = ru.customerid 
JOIN stockitemorders so 
ON oc.orderId = so.orderId 
JOIN stockitems si 
ON so.StockItemID = si.StockItemID
WHERE oc.customerid = $customerid
GROUP BY oc.orderId, si.stockitemname
ORDER BY oc.receivedate");
    $stmt->execute();
    $customerinfo = $stmt->fetchAll();
    // New array using orderId as the key
    $output = array();

    foreach ($customerinfo as $values) {
        // Define your key
        $key = $values['orderId'];
        // Assign to the new array using all of the actual values
        $output[$key][] = $values;
    }

    // Get all values inside the array, but without orderId in the keys:
    $output = array_values($output);

    ?>


        <?php foreach ($output as $test) {  foreach ($test as $info) {?>
            <div class="container-accountinfo left content">

            <b>Order</b><br>
            <?php echo $info['orderId']; ?><br>

            <b>Total</b><br>
            <?php echo $info['total']; ?><br>

            <b>Order Date</b><br>
            <?php echo $info['receivedate']; ?><br>

            <b>Products</b><br>
            <?php echo $info['stockitemname']; ?>
            </div>
<!--        --><?php }}//} else {
//            echo $info['stockitemname'];
//        }
//        array_push($arrayIds, $info['orderId']);


        ?>

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

