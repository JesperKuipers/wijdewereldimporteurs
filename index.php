<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "functions.php" ?>

    <!--Import basic imports-->
    <?php imports() ?>

</head>

<body>

    <!--Import navbar-->
    <?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<!--|-----------BEGINNING---------------------------|
    |----------Catergories--------------------------|
    |-----------------------------------------------|-->

<div class="container content">
    <div class="row">
        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="/products/overview.php?category=Novelty" src="images/chog-frog.png" height="213">
                </div>
                <div class="card-content card-action center">
                    <a class="light_grey_color center" href="/products/overview.php?category=Novelty Items">Novelty Items</a>
                </div>

            </div>
        </div>

        <div class="col s10 m3 light_grey_color">
            <div class="card">
                <div class="card-image">
                    <img href="/products/overview.php?category=Clothing" src="images/alien-officer.png" width="140" height="213">
                </div>
                <div class="card-content card-action center">
                    <a class="light_grey_color" href="/products/overview.php?category=Clothing">Clothes</a>
                </div>

            </div>
        </div>

        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="/products/overview.php?category=Packaging Materials" src="images/bubblewarp.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=Packaging Materials">Packaging Materials</a>
                </div>

            </div>
        </div>

        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="/products/overview.php?category=Mugs" src="images/mokk.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=Mugs">Mugs</a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="/products/overview.php?category=T-Shirts" src="images/The-gu.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=T-Shirts">T-shirts</a>
                </div>

            </div>
        </div>


        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="#" src="images/haaislippers.png" height="213">
                </div>
                <div class="card-content card-action center">
                    <a class="light_grey_color" href="/products/overview.php?category=Furry Footwear">Furry Footwear</a>
                </div>

            </div>
        </div>

        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="#" src="images/sushi.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=USB Novelties">USB Novelties</a>
                </div>

            </div>
        </div>

        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="#" src="images/periscope-office-nov.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=Computing Novelties">Computing Novelties</a>
                </div>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col s10 m3">
            <div class="card">
                <div class="card-image">
                    <img href="#" src="images/toys-cat.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    <a class="light_grey_color" href="/products/overview.php?category=Toys">Toys</a>
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

    <!--Import footer-->
    <?php footer() ?>

</body>
</html>
