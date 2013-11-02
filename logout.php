<?php
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./classes/user.php');
session_start();
if(isset($_SESSION['id'])){
    $user = new User(array('id' => $_SESSION['id']));
    $user->online(false);
}

session_destroy();
header("location:index.php");
?> 
