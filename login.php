<?php
require('./includes/helpers.php');
require('./includes/password.php');
require('./classes/user.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    //include the database
    include_once('./conn/db.php');
        if( !empty($_POST['email']) && !empty($_POST['password']) ){
        $data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'ip' => getIpAsInt());

        $user = new User($data);
        }else {
            $err_Login = "Incorrect Username or Password.";
        }
    }else
    {
        $err_Login = "Please fill out the form.";
    }

}
?>
