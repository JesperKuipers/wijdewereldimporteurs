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
GROUP BY si.stockitemname
ORDER BY oc.receivedate");
    $stmt->execute();
    $customerinfo = $stmt->fetchAll();
    $arrayIds = array();
    var_dump(array($customerinfo));
    foreach ($customerinfo

             as $info) {


    // $rowarray = $statement->fetchall();
    //print "<tr>\n";
    //foreach ($rowarray as $row) {
    // foreach ($row as $col) {
    //   print "\t<td>$col</td>\n";
    //   }
    //print "</tr>\n";
    // }

    ?>
    <div class="container-accountinfo left content">

<?php if (!in_array($info['orderId'], $arrayIds)){ ?>

        <b>Order</b><br>
        <?php echo $info['orderId']; ?><br>

        <b>Total</b><br>
        <?php echo $info['total']; ?><br>

        <b>Order Date</b><br>
        <?php echo $info['receivedate']; ?><br>

        <b>Products</b><br>
        <?php echo $info['stockitemname']; ?>

        <?php } else {
            echo $info['stockitemname'];
        }
        array_push($arrayIds, $info['orderId']);


        } ?>
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

