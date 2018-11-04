<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<style>
    body {
        background-color: rgb(173, 222, 248);
    }
</style>

<body>

<!--|-----------BEGINNING---------------------------|
    |--------navigation---bar-----------------------|
    |-----------------------------------------------|-->

<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="#!" class="brand-logo center"><i><img src="../images/wwi-logo.png" width="70%" alt="Image"></i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="collapsible.html"><i class="material-icons">person</i></a></li>
            <li><a href="mobile.html"><i class="material-icons">shopping_basket</i></a></li>
        </ul>


    </div>
</nav>
<ul class="sidenav" id="mobile-demo">
    <li><a href="collapsible.html"><i class="material-icons">person</i></a></li>
    <li><a href="mobile.html"><i class="material-icons">shopping_basket</i></a></li>
</ul>

<!--|--------------END------------------------------|
    |--------navigation---bar-----------------------|
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

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>
</body>
</html>