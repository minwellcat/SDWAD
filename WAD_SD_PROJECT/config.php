<?php
session_start();

$conn = new mysqli('localhost','root','','campus_events');

if($conn->connect_error){
    die("Database connection failed");
}
?>