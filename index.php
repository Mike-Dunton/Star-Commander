<?php
//include the database
include_once('./conn/db.php');

$users = $dbh->query('SELECT * FROM user');

foreach($users as $row){
    print $row["email"]. " - ". $row["password"]."<br />";
}

//close the database
$dbh = null;

?>