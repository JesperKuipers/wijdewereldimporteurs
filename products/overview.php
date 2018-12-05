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

    <!-- pagination wordt hieronder geconfigureerd -->
    <script>
        $(document).ready(function () {
            $('select').formSelect();
            init();
        });

        function init() {
            $('.pagination').remove();
            var show_per_page = $('#productsPerPage').val();
            var number_of_items = $('.products').children('.product').length;
            var number_of_pages = Math.ceil(number_of_items / show_per_page);

            $('.content').append('<ul class="pagination"></ul><input id=current_page type=hidden><input id=show_per_page type=hidden>');
            $('#current_page').val(0);
            $('#show_per_page').val(show_per_page);

            var navigation_html = '<li class="waves-effect" onclick="previous()"><a href="#!"><i class="material-icons">chevron_left</i></a></li></li>';
            var current_link = 0;
            while (number_of_pages > current_link) {
                navigation_html += '<li class="page" onclick="go_to_page(' + current_link + ')" longdesc="' + current_link + '"><a href="#!">' + (current_link + 1) + '</a></li>';
                current_link++;
            }
            navigation_html += '<li class="waves-effect" onclick="next()"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';

            $('.pagination').html(navigation_html);
            $('.pagination .page:first').addClass('active blue darken-1');

            $('.products').css('display', 'none');
            $('.products').slice(0, show_per_page / 4).css('display', 'block');
        }

        function go_to_page(page_num) {
            var show_per_page = parseInt($('#show_per_page').val(), 0);

            start_from = page_num * (show_per_page / 4);

            end_on = start_from + (show_per_page / 4);

            $('.products').css('display', 'none').slice(start_from, end_on).css('display', 'block');

            $('.page[longdesc=' + page_num + ']').addClass('active blue darken-1').siblings('.active').removeClass('active blue darken-1');

            $('#current_page').val(page_num);
        }


        function previous() {

            new_page = parseInt($('#current_page').val(), 0) - 1;
            //if there is an item before the current active link run the function
            if ($('.active').prev('.page').length == true) {
                go_to_page(new_page);
            }

        }

        function next() {
            new_page = parseInt($('#current_page').val(), 0) + 1;
            //if there is an item after the current active link run the function
            if ($('.active').next('.page').length == true) {
                go_to_page(new_page);
            }

        }

        function setFilter() {
            var url = window.location.toString();
            if (url.indexOf("&tags[]") > 0) {
                console.log('klopt');
                url = url.substring(0, url.indexOf("&tags[]"));
            }
            var tags = $("#selectFilter").val();
            url = url.replace('#!', '');
            $(tags).each(function (val, key) {
                url += "&tags[]=" + key;
            });
            document.location = url;
        }
    </script>
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
    |--------++--Producten--------------------------|
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
            <label>Aantal producten weergeven</label>
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
            <label>Producten filteren</label>
            <a class="waves-effect waves-light btn-small blue darken-1" onclick="setFilter()">Filteren</a>
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
ON ig.stockgroupid = g.stockgroupid WHERE StockGroupName LIKE :StockGroupName');
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
                    <div class="card-content card-action center">
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