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
         <h4>Fleet Name:</h4>
         <?php echo $fleet->getName(); ?>
         <h4>Credits:</h4> <?php echo $fleet->getCredits(); ?> 
        </p>
        <?php $ships = $fleet->getShips(); ?>
    <div id="accordion">
<?php
        foreach ($ships as $ship){ 
            $userShip = new Ship($ship['ship_id']); 
            $userShipClass = $userShip->getShipClass();?>
            <h3>
                <?php echo $userShip->getName(). " - <i>". $userShipClass['name']. " Class</i>"; ?>
            </h3>
            <div>
<?php
            echo "Ship Location:(".$userShip->getCoorX().",".$userShip->getCoorY().")";
            echo "<br>Actions <ul>";
            foreach($userShip->getShipActions() as $actions){
                echo "<li>". $actions['name']. "</li>";
            } ?>
        </ul>
        </div>
    <?php  } ?>

 
    </div>
<?php include_once('footer.php'); ?>