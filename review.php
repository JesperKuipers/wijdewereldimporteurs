<?php
include 'database_connectie.php';

$pdo = db_connect();

$rate_id = 0;
$customer_id=0;
$st = $pdo->prepare('SELECT MAX(rate_id) AS rate_id, MAX(customerid) AS customerid FROM rating');

$st->execute();
$result = $st->fetch();
$rate_id = $result['rate_id'];
$customer_id = $result['customerid'];
if (isset($_POST['rating'])) {
    $customer_id++;
    $rate_id++;
    $query1 = 'INSERT INTO rating (rate_id, product_id, rating, customerid) VALUES (:rate_id,:product_id,:rating, :customerid)';
    $stmt = $pdo->prepare($query1);
    $stmt->bindParam(':rate_id', $rate_id);
    $stmt->bindParam(':rating', $_POST['rating']);
    $stmt->bindParam(':product_id', $_POST['id']);
    $stmt->bindParam('customerid', $_SESSION['customerid']);
    $stmt->execute();
    ?>
    <script type="text/javascript">
        alert("You have succesfully reviewed your product");
        window.location.href = "index.php";
    </script>
<?php } ?>

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


<!-- class="content" is needed for sticky footer -->

</body>

<!--|--------------END------------------------------|
    |-------insert-code-here------------------------|
    |-----------------------------------------------|-->

<!--Import footer-->
<?php footer() ?>

</body>
</html>
