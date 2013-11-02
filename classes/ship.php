<?php

class Ship
{
    /**
     * Holds the ID related to the entry in the database
     * @var [int]
     */
    private $shipID;

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
        loadByID($id);
    }

    /**
     * Loads the ship by ship ID
     * @param [int] $id
     */
    private function loadByID( $id )
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
        $this->nName = $newName;
    }

    /**
     * Get the name of the ship
     * @return [string]
     */
    public function getName()
    {
        return $this->Name;
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

    /**
     * Get all of the actions a ship can do
     * @return [array] Returns an array of all the possible actions
     */
    private function getShipActions()
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
    private function getShipClass()
    {
        $dbh = dbHandler::getConnection();
        $select = $dbh->_dbh->prepare( 'select *
                                        FROM shipClass
                                        WHERE class_id = :classID' );
        $select->execute(array("classID" => $this->classID));
        return $select->fetchAll(PDO::FETCH_ASSOC);
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

}
