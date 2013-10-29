<?php
$pageType = 'all';
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./includes/session.php');
include_once('./classes/user.php');
include_once('./classes/fleet.php');
include_once('./classes/ship.php');

?>

<?php include_once('header.php'); ?>
<?php $fleet = new Fleet($user->userID); ?>
 <div class="content">
    <?php include_once('navigation.php'); ?>
    <div class="innerContent">
    <p> <?php echo $fleet->getName(); ?> </p>
    <p> <?php echo $fleet->getCredits(); ?> </p>
    <?php  $fleet->addToCredits(25); ?>
    <p> <?php echo $fleet->getCredits(); ?> </p>
    <?php  $fleet->persist(); ?>
    
    </div>
<?php include_once('footer.php');