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
        <p>
         <strong>Fleet Name:</strong>
         <?php echo $fleet->getName(); ?>
         <strong>Credits:</strong> <?php echo $fleet->getCredits(); ?> 
        </p>
        <?php $ships = $fleet->getShips(); ?>
    <div id="accordion">
<?php
        foreach ($ships as $ship){ ?>
                <h4><?php echo $ship['name'] ?></h4>
                <div>
<?php 
            $userShip = new Ship($ship['ship_id']);
            echo "Ship Location:(".$userShip->getCoorX().",".$userShip->getCoorY().")";
            foreach($userShip->getShipActions() as $actions){
                echo $actions['name'];
            } ?>
        </div>
    <?php  } ?>

 
    </div>
<?php include_once('footer.php'); ?>