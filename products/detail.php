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
        <a href="/index.html" class="brand-logo center"><i><img src="/images/wwi-logo.png" width="70%" alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="/inlog.html"><i class="material-icons">person</i></a></li>
            <li><a href="/shopping_basket.html"><i class="material-icons">shopping_basket</i></a></li>
        </ul>

<!--|---------------Search-bar----------------------|-->
        <form id="spatieSearchBar" method="POST" action="/Zoekbalk.php">
            <div class="input-field center searchDiv">
                <input id="search" name="zoekbalk" type="search" placeholder="Search..." class="searchbar" required>
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
    |----------Catergories--------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <?php
    include '../Database_Connectie.php';

    $db = db_connect();
    $stmt = $db->prepare
    ('SELECT StockItemName, Size, LeadTimeDays, QuantityPerOuter, TaxRate, UnitPrice, CustomFields
FROM stockitems
WHERE StockItemId = :StockItemId;');
    $stmt->bindParam('StockItemId', $_GET['itemId']);
    $stmt->execute();
    $result = $stmt->fetch();

    $customFields = explode(':', $result['CustomFields'])[1];
    $CountryOfManufacture = explode(',', $customFields)[0];
    ?>
    <div class="row">
        <div class="col s14 m6">
            <img src="/images/no-image.jpg" width="500"/>
        </div>
        <div class="col s14 m6">
            <h4>Productinformatie</h4>
            <table class="responsive-table">
                <tr>
                    <th>Productnaam</th>
                    <td><?= $result['StockItemName'] ?></td>
                </tr>
                <?php if ($result['Size']) {
                    ?>
                    <tr>
                        <th>Grootte</th>
                        <td><?= $result['Size'] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Gemaakt in</th>
                    <td><?= str_replace('"', '', $CountryOfManufacture) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!--|--------------END------------------------------|
    |-----------Catergories-------------------------|
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
