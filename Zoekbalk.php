<?php
include 'Database_Connectie.php';

try {
    $db = db_connect();

    $productnaam = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);
    $soort = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);
    $tags = filter_input(INPUT_POST, "zoekbalk", FILTER_SANITIZE_STRING);

    $zoekbalk = "%" . $_POST['zoekbalk'] . "%";
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $db->prepare("SELECT i.StockItemID, i.StockItemName, g.StockGroupName, i.tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid
WHERE i.StockItemName LIKE :zoekbalk OR g.StockGroupName LIKE :zoekbalk OR i.tags LIKE :zoekbalk");
    $stmt->bindParam('zoekbalk', $zoekbalk);
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
                        <img src="../images/no-image.jpg"/>
                    </div>
                    <div class="card-content card-action center">
                        <?= $item['StockItemName'] ?>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    </div>
    <?php
} catch (PDOException $e) {
    echo 'Connection Failed ' . $e->getMessage();
}

if ($stmt->rowCount() > 0) {

} else {
    print("<h3> No result was found! </h3>");
}

