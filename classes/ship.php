<?php

class Ship
{
    /**
     * Holds the ID related to the entry in the database
     * @var [int]
     */
    public $shipID;

    /**
     * Holds the ID of the related fleet in the database
     * @var [int]
     */
    private $fleetID;

    /**
     * Holds the ships class
     * @var [int]
     */
    private $ClassID;

    /**
     * Holds the ID of what solar system the ship is in
     * @var [type]
     */
    private $solarID;

    /**
     * Holds the current x coordinate
     * @var [type]
     */
    private $coor_x;
    /**
     * @var [type]
     */
    private $coor_y;
    /**
     * Holds the name of the ship
     * @var [string]
     */
    private $name;

    /**
     * Holds the dateTime stamp of the last action by the ship
     * @var [dateTime]
     */
    private $dt_lastAction;

    /**
     * Holds the DateTime of the last ship movement
     * @var [dataTime]
     */
    private $dt_lastMove;


    /**
     * Constructor takes a ship ID and recreates a ship
     * @param [int] $id
     */
    public function __construct($id)
    {
        $this->loadByID($id);
    }

    /**
     * Loads the ship by ship ID
     * @param [int] $id
     */
    private function loadByID($id)
    {
        $dbh = dbHandler::getConnection();

        $row = $dbh->_dbh->prepare('SELECT * FROM ship WHERE ship_id = :id');
        $row->execute(array("id" => $id));
        $this->fill( $row->fetch(PDO::FETCH_ASSOC) );
    }

    /**
     * Set the name of the ship
     * @param [String] $newName
     */
    public function setName($newName)
    {
        $this->name = $newName;
    }

    /**
     * Get the name of the ship
     * @return [string]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the x Coor of a ship
     * @return [int] the x coor of a ship
     */
    public function getCoorX()
    {
        return $this->coor_x;
    }

    /**
     * Set the x coor of a ship
     * @param [int] $value  The value to be set
     */
    public function setCoorX($value)
    {
        $this->coor_x = $value;
    }

    /**
     * Get the y coor of a ship
     * @return [int] Get the Y coor of a ship
     */
    public function getCoorY()
    {
        return $this->coor_y;
    }

    /**
     * Set the y Coor of a ship
     * @param [int] $value The value of the new y Coor
     */
    public function setCoorY($value)
    {
        $this->coor_y = $value;
    }

    public function getSolarID()
    {
        return $this->solarID;
    }

    /**
     * Get all of the actions a ship can do
     * @return [array] Returns an array of all the possible actions
     */
    public function getShipActions()
    {
        $dbh = dbHandler::getConnection();
        $select = $dbh->_dbh->prepare( 'select sA.action_id, sA.name, sA.description, sA.value
                                        FROM shipActions sAs
                                        JOIN shipAction sA ON sAs.action_id = sA.action_id
                                        WHERE sAs.class_id = :classID' );
        $select->execute(array("classID" => $this->classID));
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the class of a ship
     * @return [array] [an assoc array of the class properties]
     */
    public function getShipClass()
    {
        $dbh = dbHandler::getConnection();
        $select = $dbh->_dbh->prepare( 'select *
                                        FROM shipClass
                                        WHERE class_id = :classID' );
        $select->execute(array("classID" => $this->classID));
        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Scans the nearby area for any objects
     * @return [array] an assoc array of all the nearby objects
     */
    public function scan()
    {
        $dbh = dbHandler::getConnection();
        $select = $dbh->_dbh->prepare( 'select so.name, so.stellar_id, so.coor_x, so.coor_y, sos.name AS stellarName
                                        FROM stellarObject so
                                        JOIN stellarObjects sos ON so.type_id = sos.type_id
                                        WHERE so.solar_id = :solarID
                                        AND so.coor_x <= :maxX
                                        AND so.coor_x >= :minX
                                        AND so.coor_y <= :maxY
                                        AND so.coor_y >= :minY' );
        $select->execute(array("solarID" => $this->solarID,
                               "maxX"    => $this->coor_x+10,
                               "minX"    => $this->coor_x-10,
                               "maxY"    => $this->coor_y+10,
                               "minY"    => $this->coor_y-10,
                               )
                        );
        $stelarObjects = $select->fetchAll(PDO::FETCH_ASSOC);

        $select2 = $dbh->_dbh->prepare( 'select s.ship_id, s.name, s.coor_x, s.coor_y, sC.name AS className
                                        FROM ship s
                                        JOIN shipClass sC ON s.class_id = sC.class_id
                                        WHERE s.solar_id = :solarID
                                        AND s.coor_x <= :maxX
                                        AND s.coor_x >= :minX
                                        AND s.coor_y <= :maxY
                                        AND s.coor_y >= :minY' );
        $select2->execute(array("solarID" => $this->solarID,
                               "maxX"    => $this->coor_x+10,
                               "minX"    => $this->coor_x-10,
                               "maxY"    => $this->coor_y+10,
                               "minY"    => $this->coor_y-10,
                               )

                        );
        $ships = $select2->fetchAll(PDO::FETCH_ASSOC);

        $scanResults = array_merge($ships, $stelarObjects);

        return $scanResults;
    }

    /**
     * The Move function updates the coorx and coory of a ship
     * MUST CALL THE PERSIST function after calling this.
     * @param  [type] $coor_x  [the x coor]
     * @param  [type] $coor_y  [the y coor]
     * @param  [type] $solarID [the solar system]
     * @return [type]          [true if possible false if not]
     */
    public function move($coor_x, $coor_y)
    {
        if($coor_x >= $this->coor_x-10 && $coor_x <= $this->coor_x+10 && $coor_y >= $this->coor_y-10 && $coor_y <= $this->coor_y+10)
        {
            $this->coor_x = $coor_x;
            $this->coor_y = $coor_y;
            return true;
        }
        return false;
    }

     /**
     * Takes an array of data and sets the objects data.
     * @param  [Array] $row
     */
    private function fill( $row )
    {
        $this->shipID = $row['ship_id'];
        $this->name = $row['name'];
        $this->fleetID = $row['fleet_id'];
        $this->classID = $row['class_id'];
        $this->solarID = $row['solar_id'];
        $this->coor_x = $row['coor_x'];
        $this->coor_y = $row['coor_y'];
        $this->dt_lastMove = $row['dt_lastMove'];
        $this->dt_lastAction = $row['dt_lastAction'];
    }
    /**
     * Get the objects data as an array
     * @return [Array]
     */
    private function toArray()
    {
        return array("shipID" => $this->shipID,
                     "name" => $this->name,
                     "fleetID" => $fleetID,
                     "classID" => $classID,
                     "solarID" => $solarID,
                     "coor_x" => $coor_x,
                     "coor_y" => $coor_y,
                     "dt_lastMove" => $dt_lastMove,
                     "dt_lastAction" => $dt_lastAction);
    }

    /**
     * persist the object data to the database.
     */
    public function persist()
    {
        $dbh = dbHandler::getConnection();

        $update = $dbh->_dbh->prepare( 'UPDATE ship
                                        SET name = :name,
                                            solar_id = :solarID,
                                            coor_x = :coor_x,
                                            coor_y = :coor_y,
                                            dt_lastMove = :dt_lastMove,
                                            dt_lastAction = :dt_lastAction
                                        WHERE ship_id = :shipID');
        $update->execute($this->toArray());

        $this->loadByID($this->shipID);
    }

    /*public function printMap()
    {
        $scanResults = $this->scan();

        for($x=$this->coor_x-10; $x<$this->coor_x+10; $x++) {
            for($y=$this->coor_x-10; $y<$this->coor_x+10; $y++) {
                if($scanResults == 1){
                    echo "<span style='color:yellow; display:block; float:left'>" . $scanResults ."</span>";
                }elseif($scanResults == 2){
                    echo "<span style='color:green; display:block; float:left'>" . $scanResults ."</span>";
                }elseif($scanResults == 3){
                    echo "<span style='color:aqua; display:block; float:left'>" . $scanResults ."</span>";
                }elseif($scanResults == 4){
                    echo "<span style='color:azure; display:block; float:left'>" . $scanResults ."</span>";
                }elseif($scanResults == 5){
                    echo "<span style='color:fuchsia; display:block; float:left'>" . $scanResults ."</span>";
                }else {
                    echo "<span style='color:white; display:block; float:left'>" . $scanResults. "</span>";
                }
            }
        print "<br style='clear:both>'";
        }
    }*/

}
