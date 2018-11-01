<?php


include 'Database_Connectie.php';
try {
    $db = db_connect();
    $stmt = $db->query('SELECT StockItemName, StockGroupName 
FROM stockitems i 
JOIN stockitemstockgroups ig 
ON i.Stockitemid = ig.StockitemID 
JOIN stockgroups g 
ON ig.stockgroupid = g.stockgroupid');

    while ($row = $stmt->fetch()) {
        echo $row['StockItemName'] . '<br>';
    }
} catch (PDOException $a) {
    echo  $a->getMessage();
}