<?php
include "../Database_Connectie.php"
?>

<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>
    <!--Import main.css-->
    <link type="text/css" rel="stylesheet" href="/css/main.css"/>
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
        <a href="/index.html" class="brand-logo center"><i><img src="/images/wwi-logo.png" width="70%"
                                                               alt="Image"></i></a>
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
    $db = db_connect();
    $product_array = $db->query("SELECT * FROM stockitems ORDER BY stockitemid ASC");
    $result = $product_array->fetchAll();

    if (!empty($result)) {
        foreach ($result as $value) {
            ?>
            <div class="product-item">
                <form method="post"
                      action="index.php?action=add&code=<?php echo $value["StockItemID"]; ?>">
                    <div class="product-image"><img src="<?php echo $value["Photo"]; ?>"></div>
                    <div class="product-tile-footer">
                        <div> <?php echo $value["StockItemName"]; ?></div>
                        <div> <?php echo "$" . $value["RecommendedRetailPrice"]; ?></div>
                        <div><input type="text" class="product-quantity" name="quantity" value="1" size="2"/><input

                    </div>
                </form>
            </div>
            <?php
        }
    }
    ?>
</div>


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