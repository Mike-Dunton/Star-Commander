<?php

class User
{
    public $userID;
    public $email;

    public function __construct($data)
    {
        if(array_key_exists("id", $data))
        {
            $this->loadByID($data['id']);
        }else
        {
            $this->loadByCreds($data);
        }
    }
    /*
    *   Load the user obect by username//password
    */
    private  function loadByCreds( $credentials )
    {
        $dbh = dbHandler::getConnection();

        $insert = $dbh->_dbh->prepare("SELECT *
                                       FROM user
                                       WHERE email = :email LIMIT 1");
        $insert->bindParam(':email', $credentials['email'] , PDO::PARAM_STR);
        $insert->execute();
        $row = $insert->fetch(PDO::FETCH_ASSOC);
        if(password_verify($credentials['password'], $row['password']))
        {
            $this->fill($row);
            $this->online(true);
            $this->updateIP();
        }else {
            $this->fill(array("user_id" => false, "email" => false));
        }

    }
    /*
    *   Load the user obect by user_id
    */
    private function loadByID( $id )
    {
        $dbh = dbHandler::getConnection();

        $row = $dbh->_dbh->prepare('SELECT * FROM user WHERE user_id = :id');
        $row->execute(array("id" => $id));
        $this->fill( $row->fetch(PDO::FETCH_ASSOC) );
    }

    public function online($value)
    {
        $dbh = dbHandler::getConnection();
        $update = $dbh->_dbh->prepare("UPDATE user 
                                       SET online = :value
                                       WHERE user_id = :id");
        
        $update->execute(array('value' => $value, 
               'id' => $this->userID));

    }

    private function updateIP()
    {
        $dbh = dbHandler::getConnection();
        $ip = getIpAsInt();
        $update = $dbh->_dbh->prepare("UPDATE user 
                                       SET ip = :value
                                       WHERE user_id = :id");
        
        $update->execute(array('value' => $ip, 
               'id' => $this->userID));
    }

    private function fill( $row )
    {
        $this->userID = $row['user_id'];
        $this->email = $row['email'];
    }


}