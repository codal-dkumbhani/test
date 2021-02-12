<?php
$servername = "localhost";
    $username = "phpmyadmin";
    $password = "root";
    $dbname = "test";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
      
        // Create Database
        $sql = "CREATE DATABASE test";
        if ($conn->query($sql) === TRUE) {
          echo "Database created successfully";
        } else {
          //echo "Error creating database: " . $conn->error;
        }
        
        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }      

        // sql code to create table
        $sql = "CREATE TABLE IF NOT EXISTS user1(
          id int NOT NULL AUTO_INCREMENT, 
          firstname VARCHAR(30) NOT NULL,
          lastname VARCHAR(30) NOT NULL,
          email VARCHAR(20) NOT NULL, 
          username VARCHAR(10) NOT NULL,
          pass VARCHAR(30) NOT NULL,
          bio VARCHAR(50) NOT NULL,
          img VARCHAR(100) NOT NULL,
          PRIMARY KEY(id)
          )";

        if ($conn->query($sql) === TRUE) {
        //echo "Table test created successfully";
        } else {
        echo "Error creating table: " . $conn->error;
        }
      

        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      
      // user check
      if (isset($_POST['submit'])) {
        $uname = $_POST['username'];
        $email = $_POST['email'];
      }
      $sql_u = "SELECT * FROM user WHERE username= '$uname'";
      $sql_e = "SELECT * FROM user WHERE email='$email'";
      $res_u = mysqli_query($conn, $sql_u);
      $res_e = mysqli_query($conn, $sql_e);
      
      if (mysqli_num_rows($res_u) > 0) {
        $name_error = "Sorry... username already taken"; 
        echo $name_error;	
      }else if(mysqli_num_rows($res_e) > 0){
        $email_error = "Sorry... email already taken"; 	
        echo $email_error;
      }else{
        //echo "done";
        $sql = "INSERT INTO user1 (firstname,lastname,email,username,pass,bio,img)
                  VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[uname]','$_POST[pass]','$_POST[bio]','$_POST[fileToUpload]')";

          if (mysqli_query($conn, $sql)) {
            echo "New record created successfully !";
          } else {
            echo "Error: " . $sql . " " . mysqli_error($conn);
          }
          
      }
      $conn->close();
      ?>
  
    <?php  
/*
      // user check
      if(!$error) {
        $sql="select * from user where (username='$uname' or email='$email');";
        $res=mysqli_query($conn,$sql);  
        //echo "test";
      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if ($uname==$row['username'])
        {
            echo "Username already exists";
        }
        else if($email==$row['email'])
        {
            echo "Email already exists";
        }
        else{

        //insert data in database
          $sql = "INSERT INTO user (firstname,lastname,email,username,pass,bio)
                  VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[uname]','$_POST[pass]','$_POST[bio]')";

          if (mysqli_query($conn, $sql)) {
            echo "New record created successfully !";
          } else {
            echo "Error: " . $sql . " " . mysqli_error($conn);
          }
        }

       } 
  }
    

      
        














    $conn->close();
    //echo "Connected successfully";
?>