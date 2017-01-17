<?php
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 12:57 AM
 */

function getConnection($host, $username, $password, $db, $port)
{
    return mysqli_connect($host, $username, $password, $db, $port);
}

function closeConnection($conn)
{
    mysqli_close($conn);
}