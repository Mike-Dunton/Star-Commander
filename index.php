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
        <div class="login_container">
            <p>Login Here</p>
        </div>
        <div class="login_extended">
            <form>
                Email:
                <input type="text" name="email" /> <br/>
                Password:
                <input type="password" name="password" /> <br />
                <input type="submit" /><br />
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(".login_container").click(
            function(){
                $(this).next().slideToggle(400);
            },
            function() {
                $(this).next().slideToggle(400);
            });
    </script>
    <div class="content">
        <?php
        foreach($users as $row){
            print $row["email"]. " - ". $row["password"]." - ".getIpAsString($row["ip_last_login"])."<br />";
        }
        echo "<a href='newUser.php'>Add New user</a>";
        //close the database
        $dbh = null;

        ?>
    </div>
</body>
</html>
