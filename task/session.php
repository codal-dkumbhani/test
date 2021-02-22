<?php
session_start();
if(isset($_SESSION['username']) && $_SESSION["id"] === true){
  header("location :Welcome.php");
  exit;
}
?>