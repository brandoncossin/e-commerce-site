<?php
/*
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "productdb";
*/
$serverName = "172.104.214.101";
$dBUsername = "tester";
$dBPassword = "serverpassword101!";
$dBName = "productdb";

$conn = mysqli_connect($serverName,$dBUsername,$dBPassword,$dBName);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}