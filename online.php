<?php
$pageType = 'all';
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./includes/session.php');
?>

<div class="content">
    <?php include_once('navigation.php'); ?>
    <div class="innerContent">
        <h2>Online Users</h2>
        <?php showOnlineUsers(); ?>
    </div>

</div>
<?php include_once('footer.php'); ?>
