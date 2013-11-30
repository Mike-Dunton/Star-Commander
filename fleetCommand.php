<?php
$pageType = 'player';
//include the database
include_once('./conn/db.php');
include_once('./includes/helpers.php');
include_once('./includes/session.php');
include_once('./classes/user.php');
include_once('./classes/fleet.php');
include_once('./classes/ship.php');


include_once('header.php'); ?>
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
                echo "<li><a href=fleetCommand.php?ship=".$userShip->shipID."&action=".$actions['name'].">" .$actions['name']."</a></li>";
            } ?>
        </ul>
        </div>
        <div>
            <?php
                if(isset($_GET['action'] && isset($_GET['ship']) && is_numeric($_GET['ship']))
                {
                    $shipInAction = new Ship(htmlentities($_get['ship']))
                    switch($_GET['action']) {
                        case 'scan' :
                           $results = $shipInAction->scan();
                           foreach ($results as $value) {
                               echo $value. "<br>";
                           }
                            break;
                        case 'move':

                            break;
                        default
                    }
                }

            ?>
        </div>
    <?php  } ?>


    </div>
<?php include_once('footer.php'); ?>
