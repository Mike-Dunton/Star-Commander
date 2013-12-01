<?php

function getIpAsInt()
{
    //Test if it is a shared client
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }

    return ip2long($ip);
}

function getIpAsString($ip)
{
    return long2ip($ip);
}

function showOnlineUsers()
{
  $dbh = dbHandler::getConnection();
  $select = $dbh->_dbh->prepare("SELECT email, dt_joined
                               FROM user
                               WHERE online = 1");
  $select->execute();
  $result = $select->fetchAll(PDO::FETCH_ASSOC);

  foreach($result as $row)
    echo "User: ". $row['email']. "is online and has been a member since ". $row['dt_joined'];

}
?>