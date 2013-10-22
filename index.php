<?php
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');

$users = $dbh->query('SELECT * FROM user');
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
            <p>Login</p>
        </div>
        <div class="login">
            <form action="login.php" method="post">
               <p> Email:
                <input type="text" name="email" /> </p>
               <p> Password:
                <input type="password" name="password" /> </p>
                <input type="submit" /><br />
            </form></p>
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
        <li class="firstItem"><a href="#">Home</a></li>
        <li><a href="#">Home</a></li>
        <li><a href="#">Fleet</a></li>
        <li><a href="#">Discussion Board</a></li>
        <li><a href="#">Who is Online</a></li>
        <li><a href="#">Politics</a></li>
        <li><a href="#">Justice</a></li>
        <li class="lastItem"><a href="#">Entertainment</a></li>
    <div>
           <?php
            foreach($users as $row){
		echo "<p>";
                print $row["email"]. " - ". $row["password"]." - ".getIpAsString($row["ip_last_login"])."</p>";
            }
            echo "<p><a href='newUser.php'>Add New user</a></p>";
            //close the database
            $dbh = null;

            ?>
        </div>
    </div>
</body>
</html>
