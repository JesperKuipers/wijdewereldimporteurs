<!DOCTYPE html>
<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php require "functions.php" ?>
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

<div class="container-index content">
    <div class="row">
        <div class="col s4">
            <div class="card">
                <a class="light_grey_color center" href="/products/overview.php?category=Novelty Items">
                <div class="card-image">
                    <img href="/products/overview.php?category=Novelty" src="images (temp)/chog-frog.png" height="213">
                </div>
                <div class="card-content card-action center">
                    Novelty Items
                </div>
                </a>
            </div>
        </div>

        <div class="col s4 light_grey_color">
            <div class="card">
                <a class="light_grey_color center" href="/products/overview.php?category=Clothing">
                <div class="card-image">
                    <img href="/products/overview.php?category=Clothing" src="images (temp)/alien-officer.png" width="140" height="213">
                </div>
                <div class="card-content card-action center">
                    Clothes
                </div>
                </a>
            </div>
        </div>

        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=Packaging Materials">
                <div class="card-image">
                    <img href="/products/overview.php?category=Packaging Materials" src="images (temp)/bubblewarp.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    Packaging Materials
                </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=Mugs">
                <div class="card-image">
                    <img href="/products/overview.php?category=Mugs" src="images (temp)/mokk.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    Mugs
                </div>
                </a>
            </div>
        </div>
    
        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=T-Shirts">
                <div class="card-image">
                    <img href="/products/overview.php?category=T-Shirts" src="images (temp)/The-gu.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    T-shirts
                </div>
                </a>
            </div>
        </div>


        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=Furry Footwear">
                <div class="card-image">
                    <img href="#" src="/images%20(temp)/haaislippers.png" height="213">
                </div>
                <div class="card-content card-action center">
                    Furry Footwear
                </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=USB Novelties">
                <div class="card-image">
                    <img href="#" src="/images%20(temp)/sushi.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    USB Novelties
                </div>
                </a>
            </div>
        </div>

        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=Computing Novelties">
                <div class="card-image">
                    <img href="#" src="/images%20(temp)/periscope-office-nov.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    Computing Novelties
                </div>
                </a>
            </div>
        </div>
        

    
        <div class="col s4">
            <div class="card">
                <a class="light_grey_color" href="/products/overview.php?category=Toys">
                <div class="card-image">
                    <img href="#" src="/images%20(temp)/toys-cat.png" height="213">
                </div>
                <div class="card-content card-action center ">
                    Toys
                </div>
                </a>
            </div>
        </div>
    </div>
    </div>
</div>

<!--|--------------END------------------------------|
    |-----------Catergories-------------------------|
    |-----------------------------------------------|-->


    <!--Import footer-->
    <?php footer() ?>

</body>
</html>