<?php
function db_connect()
{
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];


    /*
    Explanation:
    This file is included in making the database connection in the following way:
    $db = db_connect();
    --------------------------------------------------

    ------------------------------------------------select
    $stmt = $db->query("SELECT ID,mail FROM user");
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                                  $id = $row['ID'];
                                  $mail = $row['mail'];
                                  echo ("<tr><td>$id</td><td>$mail</td></tr>");
                                }--
    --------------------------------------------------
    insert
    $statement = $db->prepare("INSERT INTO table(item1,item2)
              VALUES(:item1variable,:item2variable)");
              $statement->execute(array(
                "item1variable" => "$var",
                "item2variable" => "$var2"
                ));
    --------------------------------------------------
    --------------------------------------------------
    update
    $sql = "UPDATE webshopkeys
                SET status = :stat
                WHERE webshop = :weburl";
        $statement = $db->prepare($sql);
        $statement->bindValue(":stat", $new);
        $statement->bindValue(":weburl", $weburl);
        $count = $statement->execute();
    --------------------------------------------------
    --------------------------------------------------
    delete
    $sql = "DELETE FROM shopinfo WHERE webshopkeys_webshop=:webshopkeys_webshop AND userid = :userid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":webshopkeys_webshop",$removekey);
    $stmt->bindValue(":userid",$_SESSION['GLOBALID']);
    $stmt->execute();
    --------------------------------------------------
    --------------------------------------------------


    for select update insert

    try{
    select update insert statement
    }
    catch(PDOException $e){
        echo $e->getMessage();
      }
    */
    $localAddresses = ['127.0.0.1', 'localhost'];

    if ((isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $localAddresses)) || (isset($_SERVER['SERVER_ADDR']) && in_array($_SERVER['SERVER_ADDR'], $localAddresses)) || (isset($_SERVER['SERVER_NAME']) && in_array($_SERVER['SERVER_NAME'], $localAddresses))) {
        $db = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', $options);
    } else {
        $db = new PDO('mysql:host=5.189.176.248;dbname=jesper_wwi;charset=utf8', 'jesper_website', 'r6KnZEQrWA', $options);
    }
//    $db = new PDO('mysql:host=5.189.176.248;dbname=jesper_wwi;charset=utf8', 'jesper_website', 'r6KnZEQrWA', $options);
    return $db;
}

?>
