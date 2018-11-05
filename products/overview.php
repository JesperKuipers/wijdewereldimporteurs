<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="/css/main.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        body {
            background-color: rgb(173, 222, 248);
        }

    </style>

    <script>
        $(document).ready(function () {
            $('select').formSelect();
            init();
        });

        function setInit() {
            init();
        }

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
            $('.pagination .page:first').addClass('active');

            $('.products').css('display', 'none');
            $('.products').slice(0, show_per_page / 4).css('display', 'block');
        }

        function go_to_page(page_num) {
            var show_per_page = parseInt($('#show_per_page').val(), 0);

            start_from = page_num * (show_per_page / 4);

            end_on = start_from + (show_per_page / 4);

            $('.products').css('display', 'none').slice(start_from, end_on).css('display', 'block');

            $('.page[longdesc=' + page_num + ']').addClass('active').siblings('.active').removeClass('active');

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

<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->



<!--|-------Nav-bar-en-rechter-icons----------------|-->
<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="/index.html" class="brand-logo center"><i><img src="/images/wwi-logo.png" width="70%" alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="/inlog.html"><i class="material-icons">person</i></a></li>
            <li><a href="/shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
        </ul>

<!--|---------------Search-bar----------------------|-->
        <form id="spatieSearchBar">
            <div class="input-field center searchDiv">
                <input id="search" type="search" placeholder="Search for products" class="searchbar" required>
                <label class="label-icon material-icons" for="search"><i>search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>

<!--|--------------Mobile-menu----------------------|-->
    </div>
</nav>
<ul class="sidenav" id="mobile-demo">
    <li><a href="/inlog.html"><i class="material-icons">person</i></a></li>
    <li><a href="/shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
    <!--todo: search balk hierin -->
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!--|-----------BEGINNING---------------------------|
    |----------Producten--------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <br/>
    <div class="row">
        <div class="input-field col s3">
            <select onchange="setInit()" id="productsPerPage">
                <option value="8">8</option>
                <option value="16" selected>16</option>
                <option value="32">32</option>
                <option value="64">64</option>
            </select>
            <label>Aantal producten weergeven</label>
        </div>
    </div>
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
</div>

<!--|--------------END------------------------------|
    |-----------Producten-------------------------|
    |-----------------------------------------------|-->

<!--|-----------BEGINNING---------------------------|
    |------------Footer-----------------------------|
    |-----------------------------------------------|-->


<footer class="page-footer blue-grey darken-3 sticky-footer">
    <div class="container">
        <div class="row center">

            <a class="blue_color" href="/Over WWI.html">Over WWI</a>
            <a class="blue_color dubbele_spatie" href="/index.html">Home page</a>

        </div>
    </div>
    <div class="footer-copyright">
        <div class="container center">
            <a class="blue_color">&copy; 2018. Wide World Importers. All Rights Reserverd. <br> Designed by ICTM1l Groep
                3</p></a>
        </div>
    </div>
</footer>

<!--|--------------END------------------------------|
    |-------------Footer----------------------------|
    |-----------------------------------------------|-->

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>
</body>
</html>