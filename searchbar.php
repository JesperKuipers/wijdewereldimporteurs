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


<div class="center content">
    <?php
    include 'database_connectie.php';

    try {
    $db = db_connect();

    $productname = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
    $sort = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
    $tags = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);

    $searchbar = "%" . $_POST['search'] . "%";
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $db->prepare("SELECT i.StockItemID, i.StockItemName, g.StockGroupName, i.tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid
WHERE i.StockItemName LIKE :search OR g.StockGroupName LIKE :search OR i.tags LIKE :search");
    $stmt->bindParam('search', $searchbar);
    $stmt->execute();
    $result = $stmt->fetchAll();

    ?>
    <?php
    $i = 0;
    foreach ($result as $item) {
    if ($i == 0) {
    ?>
    <div class="row products">
        <?php
        }
        if ($i == 4) {
        $i = 0;
        ?>
    </div>
    <div class="row products">
        <?php
        }
        $i++;
        ?>

        <div class="col s10 m3 product">
            <div class="card">
                <a href="/products/detail.php?itemId=<?= $item['StockItemID'] ?>">
                        <div class="card-image">
                        <img src="images/no-image.jpg"/>
                    </div>
                    <div class="card-content card-action center">
                        <?= $item['StockItemName'] ?>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php
} catch (PDOException $e) {
    echo 'Connection Failed ' . $e->getMessage();
}
?>




<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>