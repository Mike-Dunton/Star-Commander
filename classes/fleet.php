<?php

class Fleet
{
    
    /**
     * Holds the ID related to the entry in the database
     * @var [int]
     */
    private $FleetID;
    
    /**
     * Name of the Fleet
     * @var [string]
     */
    private $Name;
    
    /**
     * The amount of in game currancy held in this object
     * @var [int]
     */
    private $Credits;

    /**
     * Constructor takes a user ID and recreates a users fleet.
     * @param [int] $id
     */
    public function __construct($id)
    {
        $this->loadByID($id);
    }

    /**
     * Loads the fleet given a user ID
     * @param [int] $id
     */
    private function loadByID( $id )
    {
        $dbh = dbHandler::getConnection();
        $row = $dbh->_dbh->query('SELECT * FROM fleet WHERE user_id = ' .$id);
        $this->fill( $row->fetch(PDO::FETCH_ASSOC) );
    }

   /**
    *  Add Credits to a fleets bank
    * @param [int] $numCredits
    */
    public  function addToCredits($numCredits)
    {
        $this->Credits = $this->Credits + $numCredits;
    }

    /**
     * Set the name of the fleet
     * @param [String] $newName
     */
    public function setName($newName)
    {
        $this->Name = $newName;
    }

    /**
     * Get the name of the fleet
     * @return [string]
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * sets the number of credits
     * @param [int] $newCredits
     */
    public function setCredits($newCredits)
    {
        $this->Credits = $newCredits;
    }

    /**
     * Get the number of credits
     * @return [int]
     */
    public function getCredits()
    {
        return $this->Credits;
    }

    /**
     * Takes an array of data and sets the objects data.
     * @param  [Array] $row
     */
    private function fill( $row )
    {
        $this->FleetID = $row['fleet_id'];
        $this->Name = $row['name'];
        $this->Credits = $row['credits'];
    }

    /**
     * Get the objects data as an array
     * @return [Array]
     */
    private function toArray()
    {
        return array("credits" => $this->Credits,
                     "name" => $this->Name,
                     "id" => $this->FleetID);
    }

    /**
     * persist the object data to the database.
     */
    public function persist()
    {
        $dbh = dbHandler::getConnection();

        $update = $dbh->_dbh->prepare( 'UPDATE fleet
                                        SET credits = :credits, name = :name
                                        WHERE fleet_id = :id');
        $update->execute($this->toArray());

        //Update the Fleet information
        $this->loadByID($this->FleetID);
    }

}
