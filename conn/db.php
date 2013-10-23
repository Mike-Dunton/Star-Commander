<?php
class dbHandler
{
    private static $_instance;
    public $_dbh;

    private function __construct()
    {//private constructor:
        try{
            $this->_dbh = new PDO('mysql:host=localhost;dbname=StarCommand'
                ,'dbUser'
                ,'password1!',
                array(PDO::ATTR_PERSISTENT => true));

        }catch(PDOEception $e){

            echo $e->getMessage();
        }
    }
    public static function getConnection()
    {
        if (self::$_instance === null)//don't check connection, check instance
        {
            self::$_instance = new dbHandler();
        }
        return self::$_instance;
    }



}
?>