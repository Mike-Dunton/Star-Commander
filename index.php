<?php
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');

$users = $dbh->query('SELECT * FROM user');

foreach($users as $row){
    print $row["email"]. " - ". $row["password"]." - ".getIpAsString($row["ip_last_login"])."<br />";
}
echo "<a href='newUser.php'>Add New user</a>";
//close the database
$dbh = null;

?>
