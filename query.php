<?php

require 'database_connectie.php';

function getByCategoryName(string $category)
{
    $pdo = db_connect();
    $stmt = $pdo->prepare
    ('SELECT i.StockItemID, StockItemName, StockGroupName, tags, i.photo
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

function database_write($orderId, $paymentId, $status, $receiveDate, $stockitemids)
{
    $db = db_connect();
    $orderId = intval($orderId);
    $ifEmpty = empty(database_read($orderId));
    if ($ifEmpty) {
        $query = "INSERT INTO orderbycustomers(orderId, paymentid, status, customerid, receivedate) VALUES (:orderId, :paymentid, :status, :customerid, :receivedate)";
    } else {
        $query = "UPDATE orderbycustomers SET paymentid = :paymentid, status = :status, customerid = :customerid, receivedate = :receivedate WHERE orderId = :orderId";
    }
    $stmt = $db->prepare($query);
    $stmt->bindParam('orderId', $orderId);
    $stmt->bindParam('paymentid', $paymentId);
    $stmt->bindParam('status', $status);
    $stmt->bindParam('customerid', $_SESSION['customerid']);
    $stmt->bindParam('receivedate', $receiveDate);

    $stmt->execute();
    if ($ifEmpty) {
        foreach ($stockitemids as $ids) {
            $query2 = "INSERT INTO stockitemorders(orderId, StockItemId) VALUES (:orderId, :stockitemids)";
            $statement = $db->prepare($query2);
            $statement->bindParam('orderId', $orderId);
            $statement->bindParam('stockitemids', $ids);
            $statement->execute();
        }
    }
}
