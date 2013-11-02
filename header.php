<?php
if(isset($_SESSION['id'])){
    $user = new User(array('id' => $_SESSION['id']));}
?>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="./includes/css/style.css" />
  <link rel="stylesheet" href="./includes/css/jquery-ui-1.10.3.custom.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  

    <script type="text/javascript">
        $(function() {
            $("#accordion").accordion();
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="top_Bar">
            <?php
            if(isset($_SESSION['id'])) {
                echo ("<p>Welcome ". $user->email. " ");
            }else {
                echo "<p>Login</p>" ;
            } ?>
        </div>
        <div class="login">
        <?php if(isset($_SESSION['id']) ){ ?>
        <br /><label>&nbsp;</label><a href="logout.php">Logout</a><br /><br />
    <?php }else {?>
        <br />
            <form action="login.php" method="post">
               <label>Email:</label><input type="text" name="email" />
                <label>Password:</label><input type="password" name="password" /><br />
                <label>&nbsp; </label><input value="Login" style="align:center" type="submit" /><br />
            </form>
    <?php } ?>
        </div>
        <div class="header">
            <p>Space Commander</p>
        </div>
    <script type="text/javascript">
        $(".top_Bar").click(
            function(){
                $(this).next().slideToggle(400);
            },
            function() {
                $(this).next().slideToggle(400);
            });
    </script>