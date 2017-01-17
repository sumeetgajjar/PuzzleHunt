<?php
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 3:20 AM
 */

function checkParam($paramName)
{
    return isset($_POST[$paramName]) && !empty($_POST[$paramName]);
}