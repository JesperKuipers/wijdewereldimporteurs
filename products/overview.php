<!DOCTYPE html>
<?php
include '../query.php';

$result = getByCategoryName($_GET['category']);
?>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>
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
        <div class="input-field col s5 offset-s4">
            <select id="selectFilter" multiple>
                <?php
                $list = array();
                foreach ($result as $value) {
                    foreach (json_decode($value['tags']) as $tags) {
                        if (!in_array($tags, $list)) {
                            ?>
                            <option <?= isset($_GET['tags']) && in_array($tags, $_GET['tags']) ? 'selected' : '' ?>><?= $tags ?></option>
                            <?php
                        }
                        array_push($list, $tags);
                    }

                } ?>
            </select>
            <label>Filter products</label>
            <a class="waves-effect waves-light btn-small blue darken-1" onclick="setFilter()">Filter</a>
        </div>
    </div>
    <?php

    $db = db_connect();
    $stmt = $db->prepare
    ('SELECT i.StockItemID, StockItemName, StockGroupName
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid 
WHERE StockGroupName LIKE :StockGroupName');
    $category = '%' . $_GET['category'] . '%';
    $stmt->bindParam('StockGroupName', $category);
    $stmt->execute();
    $i = 0;

    $result = isset($_GET['tags']) && isset($resultWithTags) ? $resultWithTags : $result;

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


<!--|--------------END------------------------------|
    |------------Products---------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>