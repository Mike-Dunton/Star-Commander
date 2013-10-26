<?php

class Fleet
{
    public $fleetID;
    public $name;
    private $credits;

    public function __construct($id)
    {
        loadByID($id);
    }

    /*
    *   Get the fleet data by userID
    */
    private function loadByID( $id )
    {
        $dbh = dbHandler::getConnection();

        $row = $dbh->_dbh->query('SELECT * FROM fleet WHERE user_id = ' .$id);
        $this->fill( $row->fetch(PDO::FETCH_ASSOC) );
    }

    /*
    *   Add Credits to a fleets bank
    */
    public  function addToCredits($numCredits)
    {
        $dbh = dbHandler::getConnection();

        $update = $dbh->_dbh->prepare( 'UPDATE fleet
                                        SET credits = credits + :numCredits
                                        WHERE user_id = :id');
        $update->execute(array("numCredits" => $numCredits,"id" => $fleetID));

        //Update the Fleet information
        this->loadByID($fleetID);
    }

    /*
    *   Does the actual filling of class data
    */
    private function fill( $row )
    {
        $this->fleetID = $row['fleet_id'];
        $this->name = $row['name'];
        $this->credits = $row['credits'];
    }
}