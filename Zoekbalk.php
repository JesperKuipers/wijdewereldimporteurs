<?php
require 'database_connectie.php';

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
<!DOCTYPE html>
<html>
<head>

    <!--Include functions.php for lay-out-->
    <?php require "functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>
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

    </script>
</head>

<body>

<!--Import navbar-->
<?php navbar() ?>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!-- class="content" is nodig voor sticky footer -->


<div class="container content">
    <br/>
    <div class="row">
        <div class="input-field col s3">
            <select onchange="init()" id="productsPerPage">
                <option value="8">8</option>
                <option value="16" selected>16</option>
                <option value="32">32</option>
                <option value="64">64</option>
            </select>
            <label>Aantal producten weergeven</label>
        </div>
    </div>
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




<?php footer() ?>
</body>
</html>
