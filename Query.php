<?php


include 'Database_Connectie.php';

function get(string $table, array $fields = [], string $where = null): array
{
    $pdo = db_connect();
    $stmt = $pdo->query('SELECT `' . $table . '`.'. $fields . ' FROM `' . $table . '` ' . (!empty($where) ? 'WHERE ' . $where : null));
    $stmt->execute();
    if ($data = $stmt->fetchAll()) {
        return $data;
    }

}

function getByCategoryName(string $category)
{
    $pdo = db_connect();
    $stmt = $pdo->prepare
    ('SELECT i.StockItemID, StockItemName, StockGroupName, tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid WHERE StockGroupName = :StockGroupName');
    $stmt->bindParam('StockGroupName', $category);
    $stmt->execute();
    if ($data = $stmt->fetchAll()) {
        return $data;
    }
}
