<?php

$host = '10.1.2.189';
$user = 'my.casalen2';
$pw = 'fv3crclu';
$database = 'my_casalen2_Netflix';

$mysqli = new mysqli($host, $user, $pw, $database);

if($mysqli->connect_errno)
{
    echo "Failed to connect. (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}



?>