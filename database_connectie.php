<?php
function db_connect()
{
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];


    /*
    uitleg
    dit bestand include je in je
    aanroepen van de connectie kan op de volgende manier:
    $db = db_connect();
    --------------------------------------------------
    select
    $stmt = $db->query("SELECT ID,mail FROM user");
                                while($rij = $stmt->fetch(PDO::FETCH_ASSOC)){

                                  $id = $rij['ID'];
                                  $mail = $rij['mail'];
                                  echo ("<tr><td>$id</td><td>$mail</td></tr>");
                                }
    --------------------------------------------------
    --------------------------------------------------
    insert
    $statement = $db->prepare("INSERT INTO tabel(item1,item2)
              VALUES(:item1variabele,:item2variabele)");
              $statement->execute(array(
                "item1variabele" => "$var",
                "item2variabele" => "$var2"
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


    voor select update insert

    try{
    select update insert statement
    }
    catch(PDOException $e){
        echo $e->getMessage();
      }
    */
    $localAddresses = ['127.0.0.1', 'localhost'];

    if(in_array($_SERVER['SERVER_ADDR'] ?? $_SERVER['SERVER_NAME'], $localAddresses)) {
        $db = new PDO('mysql:host=localhost;dbname=wideworldimporters;charset=utf8', 'root', '', $options);
    } else {
        $db = new PDO('mysql:host=5.189.176.248;dbname=jesper_wwi;charset=utf8', 'jesper_website', 'r6KnZEQrWA', $options);
    }
    return $db;
}

?>
