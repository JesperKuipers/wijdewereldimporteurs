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
{
    $db = db_connect();
    $query = 'SELECT s.*, h.*, c.*, g.*
FROM stockitems AS s
JOIN stockitemholdings AS h
ON s.StockItemID = h.StockItemID
JOIN stockitemstockgroups ig
ON s.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid
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
    $cookieResults = array();

    if (isset($_COOKIE['shopping_cart'])) {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach ($cart_data as $value) {
            array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
        }
    }

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
    $stmt->bindValue('receivedate', date('Y-m-d', strtotime($receiveDate)));

    $stmt->execute();
    if ($ifEmpty) {
        foreach ($cookieResults as $result) {
            $stockitem = findkey($result, 'StockItemID');
            $quantity = findkey($result, 'item_quantity');

            $query2 = "INSERT INTO stockitemorders(orderId, StockItemId, quantity) VALUES (:orderId, :stockitemids, :quantity)";
            $statement = $db->prepare($query2);
            $statement->bindParam('orderId', $orderId);
            $statement->bindParam('stockitemids', $stockitem['StockItemID']);
            $statement->bindParam('quantity', $quantity['item_quantity']);
            $statement->execute();
            $query3 = "UPDATE stockitemholdings SET QuantityOnHand = :QuantityOnHand WHERE StockItemID = :StockItemID";
            $executement = $db->prepare($query3);
            $executement->bindValue('QuantityOnHand', $stockitem['QuantityOnHand'] - $quantity['item_quantity']);
            $executement->bindParam('StockItemID', $stockitem['StockItemID']);
            $executement->execute();
        }
    }
}

function findkey($array, $keysearch)
{
    // is in base array?
    if (array_key_exists($keysearch, $array)) {
        return $array;
    }

    // check arrays contained in this array
    foreach ($array as $element) {
        if (is_array($element)) {
            if (findkey($element, $keysearch)) {
                return $element;
            }
        }

    }

    return false;
}