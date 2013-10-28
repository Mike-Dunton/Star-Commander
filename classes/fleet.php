<?php

class Fleet
{
    private $FleetID;
    private $Name;
    private $Credits;

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
        $update->execute(array("numCredits" => $numCredits,"id" => $FleetID));

        //Update the Fleet information
        this->loadByID($FleetID);
    }

    public function setName($newName)
    {
        $this->Name = $newName;	
    }
    public function getName()
    {
        return $this->Name;
    }
    public function setCredits($newCredits)
    {
        $this->Credits = $newCredits; 
    }
    public function getCredits()
    {
        return $this->Credits;
    }

    /*
    *   Does the actual filling of class data
    */
    private function fill( $row )
    {
        $this->FleetID = $row['fleet_id'];
        $this->Name = $row['name'];
        $this->Credits = $row['credits'];
    }


}
