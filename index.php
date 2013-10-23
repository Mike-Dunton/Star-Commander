<?php
$pageType = 'all';
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./includes/session.php');
include_once('./classes/user.php');
if(isset($_SESSION['id'])){
    $user = new User(array('id' => $_SESSION['id']));}
?>
<html>
<head>
    <title>Home Page</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="./includes/css/style.css" />
</head>
<body>
    <div class="container">
        <div class="top_Bar">
            <?php if(isset($_SESSION['id']) )
                   { 
                     echo ("<p>Welcome ". $user->email. " ");
                  }
                   else
                   { 
                    echo "<p>Login</p>" ;
                } ?>
        </div>
        <div class="login">
        <br />
            <form action="login.php" method="post">
               <label>Email:</label><input type="text" name="email" />
                <label>Password:</label><input type="password" name="password" /><br />
                <label>&nbsp; </label><input value="Login" style="align:center" type="submit" /><br />
            </form></p>
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
 <div class="content">
     <div id="navigation">
        <li><a href="#">Home</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Fleet</a></li>
        <li><a href="#">Discussion Board</a></li>
        <li><a href="#">Who is Online</a></li>
        <li><a href="#">Politics</a></li>
        <li><a href="#">Justice</a></li>
    </div>
           
        </div>
        <div class="footer">
            <p>Copyright 2013 Michael Dunton. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
