<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <?php
    include '../database_connectie.php';

    $db = db_connect();
    $stmt = $db->prepare
    ('SELECT s.*, h.*, c.*
FROM stockitems AS s
JOIN stockitemholdings AS h
ON s.StockItemID = h.StockItemID
JOIN colors AS c
ON s.ColorID = c.ColorID
WHERE s.StockItemId = :StockItemId;');
    $stmt->bindParam('StockItemId', $_GET['itemId']);
    $stmt->execute();
    $result = $stmt->fetch();

    $customFields = explode(':', $result['CustomFields'])[1];
    $CountryOfManufacture = explode(',', $customFields)[0];
    ?>
    <div class="row">
        <div class="col s14 m6">
            <img src="/images/no-image.jpg" width="500"/>
        </div>
        <div class="col s14 m6">
            <h4>Productinformatie</h4>
            <table class="responsive-table">
                <tr>
                    <th>Productnaam</th>
                    <td><?= $result['StockItemName'] ?></td>
                </tr>
                <?php if ($result['Size']) {
                    ?>
                    <tr>
                        <th>Grootte</th>
                        <td><?= $result['Size'] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Gemaakt in</th>
                    <td><?= str_replace('"', '', $CountryOfManufacture) ?></td>
                </tr>
                <?php if ($result['MarketingComments']) {
                     ?>
                <tr>
                    <th>Extra Informatie</th>
                    <td><?= $result['MarketingComments'] ?></td>
                </tr>
                <?php } ?>

                <tr>
                    <th>Prijs</th>
                    <td> &euro; <?= $result['RecommendedRetailPrice'] ?></td>
                </tr>
                <tr>
                    <th>Kleur</th>
                    <td><?= $result['ColorName'] ?></td>
                </tr>
                <tr>
                    <th>Voorraad</th>
                    <td><?= $result['QuantityOnHand'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>