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
?>