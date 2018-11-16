<?php
include '../Database_Connectie.php';

$db = db_connect();
$stmt = $db->prepare
('SELECT i.StockItemID, StockItemName, StockGroupName, tags
FROM stockitems i
JOIN stockitemstockgroups ig
ON i.Stockitemid = ig.StockitemID
JOIN stockgroups g
ON ig.stockgroupid = g.stockgroupid 
WHERE StockGroupName LIKE StockGroupName');
$category = '%' . $_GET['category'] . '%';
$stmt->bindParam('StockGroupName', $category);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<html>
<head>

    <!--Include functions.php for lay-out-->
    <?php include "functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

    <style>
        body {
            background-color: rgb(173, 222, 248);
        }

    </style>

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
            $('.pagination .page:first').addClass('active dark_blue_color');

            $('.products').css('display', 'none');
            $('.products').slice(0, show_per_page / 4).css('display', 'block');
        }

        function go_to_page(page_num) {
            var show_per_page = parseInt($('#show_per_page').val(), 0);

            start_from = page_num * (show_per_page / 4);

            end_on = start_from + (show_per_page / 4);

            $('.products').css('display', 'none').slice(start_from, end_on).css('display', 'block');

            $('.page[longdesc=' + page_num + ']').addClass('active dark_blue_color').siblings('.active').removeClass('active dark_blue_color');

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

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |----------Producten--------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <?php
    include '../Database_Connectie.php';

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

    foreach ($stmt->fetchAll() as $item) {
    if ($i == 0) {
    ?>
    <div class="row">
        <?php
        }
        if ($i == 4) {
        $i = 0;
        ?>
    </div>
    <div class="row">
        <?php
        }
        $i++;
        ?>


        <div class="col s10 m3">
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
</div>

<!--|--------------END------------------------------|
    |-----------Producten-------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>