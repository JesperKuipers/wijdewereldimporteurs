<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "../functions.php" ?>
    <?php include '../query.php';?>
    <!--Import basic imports-->
    <?php imports() ?>

    <?php if (isset($_GET['cookie']) && $_GET['cookie'] == 'set') { ?>
        <script>
            $(function () {
                //initialize all modals
                $('.modal').modal();

                //now you can open modal from code
                $('.modal').modal('open');
            })
        </script>
    <?php } ?>
</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<div class="container content">

<?php
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
    <?php
    $db = db_connect();
    $img = $db->prepare("SELECT photo FROM stockitems WHERE StockItemId = :StockItemId;");
    $img->bindParam('StockItemId', $result['StockItemID']);

    $img->execute();
    $data = $img->fetch();
    ?>
    <div class="row">
        <div class="col s14 m6">
            <!-- Slideshow container -->
            <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                    <div class="numbertext">1 / 3</div>
                    <?= '<img src="data:image/jpeg;base64,'.base64_encode($data['photo']).'" alt="photo" style="width:100%">'; ?>
                    <div class="text">frontal view</div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">2 / 3</div>
                    <?= '<img src="/images/mokk.png" style="width:100%">'; ?>
                    <div class="text">back view</div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">3 / 3</div>
                    <?= '<img src="data:image/jpeg;base64,'.base64_encode($data['photo']).'" alt="photo" style="width:100%">'; ?>
                    <div class="text">side view</div>
                </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <!-- The pics ( ͡° ͜ʖ ͡°)-->
            <div class="w3-row-padding w3-section">
                <div class="col s14 m6">
                    <div class="pic_small">
                        <?= '<img class="picture_small" src="data:image/jpeg;base64,'.base64_encode($data['photo']).'" alt="photo" style="width:20%;text-align: center;cursor:pointer" onclick="currentSlide(1)">'; ?>
                        <?= '<img class="picture_small" src="/images/mokk.png" style="width:20%;cursor:pointer;text-align: center" onclick="currentSlide(2)">'; ?>
                        <?= '<img class="picture_small" src="data:image/jpeg;base64,'.base64_encode($data['photo']).'" alt="photo" style="width:20%;text-align: center;cursor:pointer" onclick="currentSlide(3)">'; ?>
                    </div>
                </div>
            </div>

            <script>
                var images = document.querySelectorAll(".picture_small");

                images.forEach(function(i) {i.addEventListener("click", function(event) {
                    i.classList.toggle("selected");
                })});
            </script>
            <?php
// if statement???
            ?>
            <script>
                var slideIndex = 1;
                showSlides(slideIndex);

                // Next/previous controls
                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }

                // Thumbnail image controls
                function currentSlide(n) {
                    showSlides(slideIndex = n);
                }

                function showSlides(n) {
                    var i;
                    var slides = document.getElementsByClassName("mySlides");
                    var dots = document.getElementsByClassName("dot");
                    if (n > slides.length) {slideIndex = 1}
                    if (n < 1) {slideIndex = slides.length}
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace(" active", "");
                    }
                    slides[slideIndex-1].style.display = "block";
                    dots[slideIndex-1].className += " active";
                }
            </script>
        </div>
        <div class="col s14 m6">
            <form method="POST" action="shoppingbasketcookie.php">
                <input type="hidden" name="id" value="<?= $result['StockItemID'] ?>">
                <h4>Product information</h4>
                <table class="responsive-table">
                    <tr>
                        <th>Product name</th>
                        <td><?= $result['StockItemName'] ?></td>
                    </tr>
                    <?php if ($result['Size']) {
                        ?>
                        <tr>
                            <th>Size</th>
                            <td><?= $result['Size'] ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (isset($CountryOfManufacture)) { ?>
                        <tr>
                            <th>Made In</th>
                            <td><?= str_replace('"', '', $CountryOfManufacture) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($result['MarketingComments']) {
                        ?>
                        <tr>
                            <th>Extra Information</th>
                            <td><?= $result['MarketingComments'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Price</th>
                        <td> &euro; <?= $result['RecommendedRetailPrice'] ?></td>
                    </tr>
                    <?php if ($result['ColorName']) { ?>
                        <tr>
                            <th>Colour</th>
                            <td><?= $result['ColorName'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Stock</th>
                        <td><?= $result['QuantityOnHand'] ?></td>
                    </tr>
                </table>
                <br/>
                <button class="btn-small waves-effect waves-light blue darken-1" style="float: right" type="submit">In
                    winkelmandje plaatsen
                </button>
                <div class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Winkelwagentje</h4>
                        <ul class="collection">
                            <?php
                            $totalprice = 1;
                            foreach ($cookieResults as $values) {
                                foreach ($values as $value) {
                                    if (isset($value['StockItemName'])) {
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
                        <a href="/products/winkelmandje.php" class="modal-close waves-effect waves-green btn-flat">Ga naar winkelwagentje</a>
                    </div>
                </div>
        </div>
    </div>
</div>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>