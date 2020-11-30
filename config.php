<?php

$host = 'localhost:3308';
$user = 'root';
$pw = '';
$database = 'forphpconnect';

$mysqli = new mysqli($host, $user, $pw, $database);

if($mysqli->connect_errno)
{
    echo "Failed to connect. (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>