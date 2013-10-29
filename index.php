<?php
$pageType = 'all';
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./includes/session.php');
include_once('./classes/user.php');
?>

<?php include_once('header.php'); ?>
 <div class="content">
    <?php include_once('navigation.php'); ?>
    <div class="innerContent">
        <h1>News</h1>
	<hr>
        <h3>10/25/2013 Update</h3>
            <ul>
                <li>Color Scheme</li>
                <li>CSS!</li>
                <li>User Login and Logout</li>
                <li>Fleet is in progress</li>
            </ul>
    </div>

<?php include_once('footer.php');?>
