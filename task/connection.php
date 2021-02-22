<?php
require_once "session.php";
    $servername = "localhost";
    $username = "phpmyadmin";
    $password = "root";
    $dbname = "test";
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
       

if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>