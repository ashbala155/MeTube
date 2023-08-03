<?php
ob_start(); // Turns on output buffering
session_start();

//Our local time zone
date_default_timezone_set("America/New_York");

try {
    //Connection info of our database hosted on buffet 
    $con = new PDO("mysql:dbname=meTube_klkv;host=mysql1.cs.clemson.edu;", "meTube_ggdt", "meTube@password");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    //In case of exception, print below
    echo "<script type='text/javascript'>alert('Connection failed: " . $e->getMessage()."');</script>";
}
?>


