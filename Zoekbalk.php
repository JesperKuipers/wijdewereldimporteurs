<?php
include 'Database_Connectie.php';

try {
    $db = db_connect();

    $productnaam = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);
    $soort = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);
    $tags = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);


    $stmt = $db->prepare("SELECT i.StockItemName, g.StockGroupName, i.tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid
WHERE i.StockItemName LIKE '%" . $_POST['zoekbalk'] . "%' OR g.StockGroupName LIKE '%" . $_POST['zoekbalk'] . "%' OR i.tags LIKE '%" . $_POST['zoekbalk'] . "%'");
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $product = $row["StockItemName"];
        $categorie = $row["StockGroupName"];
        $tag = $row["tags"];
        echo "<li>" . $product . ' ' . "<br></li>";
    }
} catch (PDOException $e) {
    echo 'Connection Failed ' . $e->getMessage();
}

if($stmt -> rowCount() > 0){

} else{
    print("<h3> No result was found! </h3>" );
}

