<html>
<head>
    <!--Include functions.php for lay-out-->
    <?php include "../functions.php";
    include "../database_connectie.php"?>
    <!--Include functions.js-->
    <script type="text/javascript" src="/js/functions.js"></script>
    <!--Import basic imports-->
    <?php imports() ?>
</head>


<body>

<?php navbar() ?>

<!--|-----------BEGINNING---------------------------|
    |--------insert-code-here-----------------------|
    |-----------------------------------------------|-->

<?php
$db = db_connect();
$dtmreview = $db->prepare("SELECT date, name, review, reviewid FROM guestbook ORDER BY date DESC;");
$dtmreview->execute();
$reviews = $dtmreview->fetchall();

?>
<div class="container content">
    <div class="review-input">
        <div class="card" style="padding: 2%">
        <form method="post">
            <b>name:</b><input type="text" name="name" class="name-input">
            <br><b>type your review here:</b>
            <textarea name="review" rows="8" cols="128" style=" background-color: lightgray"></textarea>
            <br>
            <div id="recaptcha" class="g-recaptcha" data-callback="recaptchacallback"
                     data-sitekey="6LcBd3oUAAAAAG7IDOJi1qyXSbJ7vOZiZA6AXvk5"></div>
            <br>
            <input type="submit" value="Submit" name="reviewsubmit">
        </form>
        </div>
    </div>
</div>
<?php
if (isset($_POST['reviewsubmit'])) {
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LcBd3oUAAAAABzSR-I4wK4nXxLCM8QixPzt1pOz';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $message = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);
            $date = date("Y-m-d H:i:s");


            $sql = "INSERT INTO guestbook (name, review, date,)
            VALUES (:name, :message,:date)";
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':message', $message);
            $stmt->bindValue(':date', $date);
            $result = $stmt->execute();}}}
?>
<div class="container content">
    <div class="row">
        <div class="collumn" style="float: left"> <?php foreach($reviews as $review ){?>
             <table>
                 <tr>
                     <th>name and date<br></th>
                        <td><?php echo $review["name"] ?></td>
                        <td><?PHP
                            echo date('d/m/Y  H:i', strtotime($review['date'])); ?></td>
                 </tr>
                 <tr>
                     <th>review</th>
                        <td><?PHP
                            echo $review["review"]?></td>
                 </tr>
             </table>
                <?php print("<br><br>"); }; ?>
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