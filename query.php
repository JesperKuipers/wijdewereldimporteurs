<?php

include 'database_connectie.php';

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
{
    $db = db_connect();
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

function database_read($orderId)
{
    $db = db_connect();
    $orderId = intval($orderId);
    $query = "SELECT * FROM orderbycustomers WHERE orderId = :orderId";
    $stmt = $db->prepare($query);
    $stmt->bindParam('orderId', $orderId);

    $stmt->execute();
    if ($data = $stmt->fetch()) {
        return $data ? $data : "unknown order";
    }
}

function database_write($orderId, $paymentId, $status)
{
    $db = db_connect();
    $orderId = intval($orderId);
    if (empty(database_read($orderId))) {
        $query = "INSERT INTO orderbycustomers(orderId, paymentid, status, customerid) VALUES (:orderId, :paymentid, :status, :customerid)";
    } else {
        $query = "UPDATE orderbycustomers SET paymentid = :paymentid, status = :status, customerid = :customerid WHERE orderId = :orderId";
    }
    $stmt = $db->prepare($query);
    $stmt->bindParam('orderId', $orderId);
    $stmt->bindParam('paymentid', $paymentId);
    $stmt->bindParam('status', $status);
    $stmt->bindParam('customerid', $_SESSION['customerid']);

    $stmt->execute();
}

