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
        <div>
            <?php
            echo "Ship Location:(".$userShip->getCoorX().",".$userShip->getCoorY().") In the Solar System ". $userShip->getSolarID();
            echo "<br>Actions <ul>";
            foreach($userShip->getShipActions() as $actions){
                echo "<li><a href=fleetCommand.php?ship=".$userShip->shipID."&action=".$actions['name'].">" .$actions['name']."</a></li>";
            } ?>
        </ul>
        </div>
        <div class="actionResults">
            <?php
                if(isset($_GET['action']) && isset($_GET['ship']) && is_numeric($_GET['ship']) && $_GET['ship'] == $userShip->shipID )
                {
                    $shipInAction = new Ship(htmlentities($_GET['ship']));
                    switch($_GET['action']) {
                        case 'scan' :
                           echo "<span class='actionResultsSpan'>Scan Results</span>";
                           $results = $shipInAction->scan();
                          echo"<ul>";
                           foreach($results as $row){
                                   if(array_key_exist('ship_id')
                                           echo"<li> Ship: ". $row['name']." | ".$row['coor_x']." | ".$row['coor_y']."</li>";
                                   else
                                           echo"<li> Stelar Object: ". $row['name']." | ".$row['coor_x']." | ".$row['coor_y']."</li>";
                                }
                           echo"</ul>";
                            break;
                        case 'move':

                            break;
                    }
                }

            ?>
        </div>
</div>
    <?php  } ?>


    </div>
<?php include_once('footer.php'); ?>
