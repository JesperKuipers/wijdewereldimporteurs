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

    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <?php if (isset($_GET['cookie']) && $_GET['cookie'] == 'set') { ?>
        <script>
            $(function () {
                //initialize all modals
                $('.modal').modal();

                //now you can open modal from code
                $('#modal1').modal('open');
            })
        </script>
    <?php } ?>
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
    |----------Catergories--------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <?php
    include '../Query.php';

    $result = getByItemId($_GET['itemId']);
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    $cookieResults = array();
    foreach ($cart_data as $value) {
        array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
    }

    if (isset($result['CustomFields'])) {
        $customFields = explode(':', $result['CustomFields'])[1];
        $CountryOfManufacture = explode(',', $customFields)[0];
    }
    ?>
    <div class="row">
        <div class="col s14 m6">
            <img src="/images/no-image.jpg" width="500"/>
        </div>
        <div class="col s14 m6">
            <form method="POST" action="addToShoppingBasket.php">
                <input type="hidden" name="id" value="<?= $result['StockItemID'] ?>">
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
                    <?php if (isset($CountryOfManufacture)) { ?>
                        <tr>
                            <th>Gemaakt in</th>
                            <td><?= str_replace('"', '', $CountryOfManufacture) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($result['MarketingComments']) {
                        ?>
                        <tr>
                            <th>Extra Informatie</th>
                            <td><?= $result['MarketingComments'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Prijs</th>
                        <td> &euro; <?= $result['RecommendedRetailPrice'] ?></td>
                    </tr>
                    <?php if ($result['ColorName']) { ?>
                        <tr>
                            <th>Kleur</th>
                            <td><?= $result['ColorName'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Voorraad</th>
                        <td><?= $result['QuantityOnHand'] ?></td>
                    </tr>
                </table>
                <br/>
                <button class="btn-small waves-effect waves-light blue darken-1" style="float: right" type="submit">In
                    winkelmandje plaatsen
                </button>
                <div id="modal1" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Winkelwagentje</h4>
                        <ul class="collection">
                            <?php
                            $totalprice = 1;
                            $totalquantity = 1;
                            foreach ($cookieResults as $values) {
                                foreach ($values as $value) {
                                    if ($value['StockItemName']) {
                                        $totalprice = $totalprice + ($value['RecommendedRetailPrice'] * $values['item_quantity']);
                                        ?>
                                        <li class="collection-item avatar">
                                            <img src="/images/no-image.jpg" alt="" class="circle">
                                            <span class="title"><?= $value['StockItemName'] ?></span>
                                            <p>Stock: <?= $value['QuantityOnHand'] ?></p>
                                            <p class="secondary-content">
                                                Price: &euro; <?= $value['RecommendedRetailPrice'] ?><br/>
                                                Quantity: <?= $values['item_quantity'] ?>
                                            </p>

                                        </li>
                                    <?php }
                                }
                            } ?>
                            <li class="collection-item">
                                <span class="title">Subtotal</span>
                                <div class="secondary-content">
                                    &euro; <?= $totalprice ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="/products/detail.php?itemId=<?= $_GET['itemId'] ?>" class="modal-close waves-effect waves-green btn-flat">Verder winkelen</a>
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ga naar winkelwagentje</a>
                    </div>
                </div>
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
