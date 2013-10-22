<?php
require('./includes/helpers.php');
require('./includes/password.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    //include the database
    include_once('./conn/db.php');
        if( !empty($_POST['email']) && !empty($_POST['password']) ){
        $data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'ip' => getIpAsInt());

            $select = $dbh->prepare("SELECT email, password, ip_last_login
                                    FROM user
                                    WHERE email = :email LIMIT 1");
            $select->bindParam(':email', $data['email', PDO::PARAM_STR]);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);

        if(password_verify($data[$data['password'], $result['password'])){
            echo "You did it!";
            /*header("Location: index.php");
            die();*/
        }else {
            $err_Login = "Incorrect Username or Password.";
        }
    }else
    {

        $err_Login = "Please fill out the form.";
    }

}
?>