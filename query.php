
<?php
include 'Database_Connectie.php';
try {
    $db = db_connect();
    $stmt = $db->query
    ('');
    while ($row = $stmt->fetch()) {
        echo $row['StockItemName'] . '<br>';
    }
} catch (PDOException $a) {
    echo $a->getMessage();
}

}
