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


<div class="center content valign-wrapper">
    <div class="row" style="width: 600px;">
        <div class="card">
            <div class="card-content">
                <p>It looks like we have encoutered an issue.</p>
            </div>
            <div class="card-image">
                <img src="images (temp)/sadpuppy.jpg">
                <span class="card-title light_blue_color">Error</span>
            </div>
            <div class="card-content card-action center">
                <a class="light_grey_color center" href="/index.php">Go to the home page</a>
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