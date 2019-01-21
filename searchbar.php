<!DOCTYPE html>
<?php
include 'query.php';
?>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "functions.php" ?>
    <!--Import basic imports-->
    <?php imports() ?>
    <!--Include functions.js-->
    <script type="text/javascript" src="/js/functions.js"></script>
</head>
<body>
<?php


if (isset($_GET['tags'])) {
    $resultWithTags = [];
    foreach ($result as $key => $value) {
        foreach ($_GET['tags'] as $urlTags) {
            if (in_array($urlTags, json_decode($value['tags']))) {
                $resultWithTags[] = $value;
            }
        }

    }
}
?>

<!--Import navbar-->
<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |------------Products---------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <br/>
    <div class="row">
        <div class="input-field col s3">
            <select onchange="init()" id="productsPerPage">
                <option value="8">8</option>
                <option value="16" selected>16</option>
                <option value="32">32</option>
                <option value="64">64</option>
                <option value="128">128</option>
            </select>
            <label>Products per page</label>
        </div>
    </div>
    <?php


    try {
    $db = db_connect();

    $searchinput = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);

    $searchbar = "%" . $searchinput . "%";
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $db->prepare
    ("SELECT i.StockItemID, i.StockItemName, g.StockGroupName, i.tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid
WHERE i.StockItemName LIKE :search OR g.StockGroupName LIKE :search OR i.tags LIKE :search");
    $stmt->bindParam('search', $searchbar);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $i = 0;

    foreach ($result as $item) {
        $image = isset($item['photo']) ? '<img src="data:image/jpeg;base64,'.base64_encode($item['photo']).'" alt="photo" style="width:100%">': '<img src="../images%20(temp)/no-image.jpg" alt="photo" style="width:100%">';
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
                       <?= $image ?>
                    </div>
                    <div class="card-content card-action center" style="height: 90px">
                        <?= $item['StockItemName'] ?>
                    </div>
                </a>
                <div>
                    <?php
                    $pdo = db_connect();
                    $product_id = $item['StockItemID'];
                    $stmt = $pdo->prepare("SELECT ROUND(AVG(rating),0) FROM rating WHERE product_id = :product_id");
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    foreach ($result as $k) {
                        if ($k == 0) {
                            $k = 0;
                            while ($k < 5) {
                                echo '<i class="tiny material-icons colorstars">star_border</i>';
                                $k++;
                            }
                            echo '     No reviews found';
                        } else {
                            $stars = round($k * 2, 0, PHP_ROUND_HALF_UP);
                            $x = 1;
                            while ($x <= $stars - 1) {
                                echo '<i class="tiny material-icons colorstars">star</i>';
                                $x += 2;
                            }

                        }
                    }
                    ?>
                </div>
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
    |------------Products---------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>