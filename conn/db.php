<?php
try{
    $dbh = new PDO('mysql:host=localhost;dbname=StarCommand'
        ,'dbUser'
        ,'password1!',
        array(PDO::ATTR_PERSISTENT => true));

}catch(PDOEception $e){

    echo $e->getMessage();
}
?>