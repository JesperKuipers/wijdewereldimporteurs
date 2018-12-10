<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php" ?>
    <?php include '../query.php'; ?>
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
    if (isset($_COOKIE['shopping_cart'])) {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        $cookieResults = array();
        foreach ($cart_data as $value) {
            array_push($cookieResults, [getByItemId($value['item_id']), 'item_quantity' => $value['item_quantity']]);
        }
    }
    if (isset($result['CustomFields'])) {
        $customFields = explode(':', $result['CustomFields'])[1];
        $CountryOfManufacture = explode(',', $customFields)[0];
    }
    $db = db_connect();
    $tempquery = "SELECT Temperature FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 1";
    $stmttemp = $db->prepare($tempquery);
    $stmttemp->execute();
    $temperature = $stmttemp->fetch();


    $img = $db->prepare("SELECT Photo FROM stockitems WHERE StockItemId = :StockItemId;");
    $img->bindParam('StockItemId', $result['StockItemID']);
    $img->execute();
    $data = $img->fetch();


    $smallimg = $db->prepare("SELECT photo FROM images WHERE StockItemId = :StockItemId;");
    $smallimg->bindParam('StockItemId', $result['StockItemID']);
    $smallimg->execute();
    $data1 = $smallimg->fetchAll();
    ?>
    <div class="row">
        <div class="col s14 m6">
            <!-- Slideshow container -->
            <div class="slideshow-container">
                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                    <?= '<img src="data:image/jpeg;base64,' . base64_encode($data['Photo']) . '" alt="photo" style="width:100%">'; ?>
                </div>
                <?php
                foreach ($data1 as $foto) { ?>
                    <div class="mySlides fade">
                        <?= '<img src="data:image/jpeg;base64,' . base64_encode($foto['photo']) . '" alt="photo" style="width:100%">'; ?>
                    </div>
                <?php } ?>
                <!-- Next and previous buttons -->
                <?php if (count($data1) > 0) { ?>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <?php } ?>
            </div>
            <br>

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
                    var prepic = document.getElementsByClassName("picture_small");
                    if (n > slides.length) {
                        slideIndex = 1
                    }
                    if (n < 1) {
                        slideIndex = slides.length
                    }
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    for (i = 0; i < prepic.length; i++) {
                        prepic[i].className = prepic[i].className.replace(" active1", "");
                    }
                    slides[slideIndex - 1].style.display = "block";
                    console.log(prepic[slideIndex - 1]);
                    prepic[slideIndex - 1].className += " active1";
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
                    </tr> <?php if (strpos($result['StockItemName'], 'chocolate') || substr($result['StockItemName'], 0, 9) === "Chocolate") { ?>
                        <tr>
                            <th>Stocktemperature</th>
                            <td><?= number_format($temperature['Temperature'], 2, ',', '.') ?> &#8451;</td>
                        </tr>
                    <?php } ?>
                </table>
                <br/>
                <button class="btn-small waves-effect waves-light blue darken-1" style="float: right" type="submit">Add
                    to shopping cart
                </button>
                <div class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Shopping cart</h4>
                        <ul class="collection">
                            <?php
                            $totalprice = 0;
                            foreach ($cookieResults as $values) {
                                foreach ($values as $value) {
                                    if (isset($value['StockItemName'])) {
                                        $totalprice = $totalprice + ($value['RecommendedRetailPrice'] * $values['item_quantity']);
                                        ?>
                                        <li class="collection-item avatar">
                                            <img src="/images%20(temp)/no-image.jpg" alt="" class="circle">
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
                        <a href="/products/detail.php?itemId=<?= $_GET['itemId'] ?>"
                           class="modal-close waves-effect waves-green btn-flat">Continue shopping</a>
                        <a href="/products/shopping_basket.php" class="modal-close waves-effect waves-green btn-flat">Go
                            to shopping cart</a>
                    </div>
                </div>
            </form>
            <?php
            $pdo = db_connect();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            $customerid = $_SESSION['customerid'];
            $productid = $result['StockItemID'];
            $stmtcheck = $pdo->prepare("SELECT * FROM rating WHERE customerid = $customerid AND product_id = $productid");
            $stmtcheck->execute();
            if ($stmtcheck->rowCount() > 0){
                echo 'You already reviewed this product.';
            }else{

            ?>
            <div class="box">
                <form action="../review.php" method="post" class="rating">

                    <input type="hidden" name="id" value="<?= $result['StockItemID'] ?>">


                    <input type="radio" onchange="this.form.submit();" id="star5" name="rating" value="5"/><label
                            class="full" for="star5"
                            title="Awesome - 5 stars"></label>
                    <input type="radio" onchange="this.form.submit();" id="star4" name="rating" value="4"/><label
                            class="full" for="star4"
                            title="Pretty good - 4 stars"></label>
                    <input type="radio" onchange="this.form.submit();" id="star3" name="rating" value="3"/><label
                            class="full" for="star3"
                            title="Meh - 3 stars"></label>
                    <input type="radio" onchange="this.form.submit();" id="star2" name="rating" value="2"/><label
                            class="full" for="star2"
                            title="Kinda bad - 2 stars"></label>
                    <input type="radio" onchange="this.form.submit();" id="star1" name="rating" value="1"/><label
                            class="full" for="star1"
                            title="Sucks big time - 1 star"></label>

                    <?php
                    }
                    $queryratecustomer = "SELECT customerid FROM rating";
                    $customerratereview = $pdo->prepare($queryratecustomer);
                    $customerratereview->execute();
                    $rate = $customerratereview->fetch();


                    ?>
                </form>

                <?php
                } else {
                    echo 'First login to review this product';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="container content2">
    <?php if (count($data1) > 0) { ?>
        <div class="center row">
            <div class="visible_pic">
                <div class="pic_small_div" style="<?php if (count($data1) <= 4) {
                    echo "width: 504px";
                } else {
                    $amountsmallpictures = count($data1);
                    echo "width: calc(($amountsmallpictures*120px) + 25px)";
                } ?>">
                    <?php
                    $i = 1;
                    foreach ($data1 as $value) {
                        echo '<img class="picture_small" src="data:image/jpeg;base64,' . base64_encode($value['photo']) . '" alt="photo" style="width:100px;text-align: center;cursor:pointer" onclick="currentSlide(' . $i . ')">';
                        $i++;
                    } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row personalreview">
        <div class="col s12 m6 ">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text  personalreview">
                    <span class="card-title"><?php
                        $pdo = db_connect();
                        $reviewquery = "SELECT R.first_name, RA.rating, RA.product_id
                                      FROM registered_users R
                                      LEFT JOIN rating RA
                                      ON R.customerid = RA.customerid
                                      WHERE RA.product_id = :product_id
                                      ORDER BY RAND()
                                      LIMIT 1";
                        $stmtreviews = $pdo->prepare($reviewquery);
                        $stmtreviews->bindParam(':product_id', $result['StockItemID']);
                        $stmtreviews->execute();
                        $resultreviews = $stmtreviews->fetch(PDO::FETCH_ASSOC);
                        echo $resultreviews['first_name']
                        ?></span>
                    <h7>
                        <?php
                        if (isset($resultreviews['rating'])) {
                            for ($x = 1; $x <= $resultreviews['rating']; $x++) {
                                ?><i class="material-icons colorstars">star</i><?php
                            }
                        } else {
                            echo 'Be the first one to review this product';
                        }
                        ?>
                    </h7>
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