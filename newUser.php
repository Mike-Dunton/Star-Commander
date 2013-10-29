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

        if( $_POST['email'] == $_POST['email2'] && $_POST['password'] == $_POST['password2'] ){
            $insert = $dbh->prepare("INSERT INTO user (email, password, ip_last_login)
                                               VALUES (:email, :password, :ip)");
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        if(password_verify($_POST['password'], $data['password'])) {
                $insert->execute($data);
                $dbh = null;
                header("Location: index.php");
        die();
        }else {
        //something went wront with hashing
                die();
        }
        }else{
        $err_NewUser = "Your information is bad and you should feel bad too";
    }
    }

}
?>
<html>
<head>
    <title>New user</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="./includes/css/style.css" />
</head>
<body>
<?php if(isset($err_NewUser)){echo "<p style='padding: 10px 10px; color:#FE2EE2E;'>" . $err_NewUser. "</p>";} ?>
<div class="registration">
<form action="newUser.php" method="post">
    <label for="email">Email: </label>
    <input type="text" name="email">
    <label for="email2">Confirm Email: </label>
    <input type="text" name="email2">
    <label for="password">Password: </label>
    <input type="password" name="password">
    <label for="password2">Confirm Password:</label>
    <input type="password" name="password2">
    <input type="submit">
</form>
</div>
</body>
