<?php
include_once('./includes/helpers.php');

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
//include the database
include_once('./conn/db.php');
    if( isset($_POST['username']) && isset($_POST['password']) ){
        $data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'ip' => getIpAsInt());

        if( $data['email'] == $_POST['email2'] && $data['password'] == $_POST['password2'] ){
            $insert = $dbh->prepare("INSERT INTO `StarCommand`.`user`(`email`, `password`, `ip_last_login`) 
                                                            VALUES (':email', ':password', ':ip');");
            $insert->execute($data);
            $dbh = null;
            header("Location: index.php");
            die();
        }
    }

}
?>
<html>
<head>
    <title>New user</title>
</head>
<body>
<form action="newUser.php" method="post">
    <label for="email">Email: </label>
    <input type="text" name="email">
    <label for="email2">Confirm Email: </label>
    <input type="text" name="email2">
    <label for="password">Password: </label>
    <input type="password" name="password">
    <label for="password2">Confirm Password:</label>
    <input type="password" name="password2">
</form>
</body>