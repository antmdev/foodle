<?php
ob_start();

try {

    $con = new PDO("mysql:dbname=foodle;host=localhost", "root", "");   //use DMO & mysql to connect to DB
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);        //show us warnings if there's errors.

}

catch(PDOExeption $e) {

    echo "Connection Failed: " . $e->getMessage();                  //getMessage built in mthod of PDOexception

}

?>