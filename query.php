<?php

require 'database_connectie.php';

function get(string $table, array $fields = [], string $where = null): array
{
    $pdo = db_connect();
    $stmt = $pdo->query('SELECT `' . $table . '`.' . $fields . ' FROM `' . $table . '` ' . (!empty($where) ? 'WHERE ' . $where : null));
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

function getByItemId(int $id)
{$db = db_connect();
    $query = 'SELECT s.*, h.*, c.*
FROM stockitems AS s
JOIN stockitemholdings AS h
ON s.StockItemID = h.StockItemID
LEFT JOIN colors AS c
ON s.ColorID = c.ColorID
WHERE s.StockItemId = :StockItemId;';
    $stmt = $db->prepare($query);
    $stmt->bindParam('StockItemId', $id);

    $stmt->execute();
    if ($data = $stmt->fetch()) {
        return $data;
    }
}
