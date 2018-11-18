<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="css/main.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!--|-------Nav-bar-en-rechter-icons----------------|-->
<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="index.html" class="brand-logo center"><i><img src="images/wwi-logo.png" width="70%"
                                                               alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="inlog.html"><i class="material-icons">person</i></a></li>
            <li><a href="shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
        </ul>

        <!--|---------------Search-bar----------------------|-->
        <form id="spatieSearchBar" method="post" action="zoekbalk.php">
            <div class="input-field center searchDiv">
                <input id="search" name="search" type="search" placeholder="Search for products" class="searchbar" required>
                <label class="label-icon material-icons" for="search"><i>search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>

        <!--|--------------Mobile-menu----------------------|-->
    </div>
</nav>
<ul class="sidenav" id="mobile-demo">
    <li><a href="inlog.html"><i class="material-icons">person</i></a></li>
    <li><a href="shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
    <!--todo: search balk hierin -->
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<!-- class="content" is nodig voor sticky footer -->
<div class="center content">
    <?php
    require 'Database_Connectie.php';

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




<!--|-----------BEGINNING---------------------------|
    |------------Footer-----------------------------|
    |-----------------------------------------------|-->

<footer class="page-footer blue-grey darken-3 sticky-footer">
    <div class="container">
        <div class="row center">

            <a class="blue_color" href="Over WWI.html">Over WWI</a>
            <a class="blue_color dubbele_spatie" href="index.html">Home page</a>

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
