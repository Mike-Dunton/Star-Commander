<?php
include_once('./includes/helpers.php');

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
//include the database
include_once('./conn/db.php');
    if(isset($_POST['username']) && isset($_POST['password']))){
        $email = $_POST['email'];
        $email2 = $_POST['email2'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $ip = getIpAsInt();

        if( $email === $email2 && $password === $password2 ){
            $insert = $dbh->prepare("INSERT INTO `StarCommand`.`user`(`email`, `password`, `ip_last_login`) 
                                                            VALUES (':email', ':password', ':ip');");
            $insert->bindParam(':email', $email, PDO::PARAM_STR); //<-- Automatically sanitized by PDO
            $insert->bindParam(':password', $password, PDO::PARAM_STR);
            $insert->bindParam(':ip', $ip, PDO::PARAM_INT);
            $insert->execute();
            $dbh = null;
            header("Location: index.php");
            die();
        }
    }

}
?>

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