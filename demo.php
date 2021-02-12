
<!DOCTYPE HTML>  
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
.error {color: #FF0000;}
</style>

</head>
<body>  
<?php
 
 

//image part
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//echo "$target_file".'<br>';

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } 
   // Check file size
   elseif ($_FILES["fileToUpload"]["size"] > 500000) {
    $imgErr = "Sorry, your file is too large.";
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
      // Allow certain file formats
    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $imgErr =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
  else {
    $imgErr= "File is not an image.";
    // echo "File is not an image.";
    $uploadOk = 0;
  }
    
    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $imgErr = "Sorry, your file was not uploaded.";
    //echo '<script>alert("Sorry, your file was not uploaded.")</script>'; 
    //echo "Sorry, your file was not uploaded.<br>";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>";


    } else {
      echo "Sorry, there was an error uploading your file.<br>";
    }
  }
}




      
//condition check part
$fnameErr = $lnameErr = $emailErr = $unameErr = $passErr =$cpassErr = "";
$fname = $lname = $email = $uname = $pass = $cpass  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

 
  if (empty($_POST["fname"])) {
    $fnameErr = "First Name is required";
  } else {
    $fname = test_input($_POST["fname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is required";
  } else {
    $lname = test_input($_POST["lname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["uname"])) {
    $unameErr = "User Name is required";
  } else {
    $uname = test_input($_POST["uname"]);
    if (!preg_match("/^[0-9a-zA-Z-' ]*$/",$uname)) {
      $unameErr = "Only letters & Number & white  space allowed Special char NOT allowed ";
    }
  }

  if (empty($_POST["bio"])) {
    $bio = "";
  } else {
    $bio = test_input($_POST["bio"]);
  }

  if (empty($_POST["pass"])){
    $pass = "Password is required";
  
  }else{
    if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/",$pass)) {
      $passErr = "Lowecase,uppercase,number,minimum 8 char required ";
      
    }
    
  }

  
  if (empty($_POST["cpass"])){
    $cpass = "Conform password is requird";
  }
  if ($_POST["pass"] === $_POST["cpass"]) {
        // success!
     }
     else {
        // failed 
        $cpassErr = "password not match";
     }
  
  

  
}

//sql part

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            //echo "Database created successfully";
          } else {
            //echo "Error creating database: " . $conn->error;
          }
          
          if($conn === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }      
  
          // sql code to create table
          $sql = "CREATE TABLE IF NOT EXISTS user(
            id int NOT NULL AUTO_INCREMENT, 
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(20) NOT NULL, 
            username VARCHAR(10) NOT NULL,
            pass VARCHAR(30) NOT NULL,
            cpass VARCHAR(30) NOT NULL,
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
          $uname = $_POST['uname'];
          $email = $_POST['email'];
        }
        $sql_u = "SELECT * FROM user WHERE username= '$uname'";
        $sql_e = "SELECT * FROM user WHERE email='$email'";
        $res_u = mysqli_query($conn, $sql_u);
        $res_e = mysqli_query($conn, $sql_e);
        $name_error ="";
        $email_error="";
        if (mysqli_num_rows($res_u) > 0) {
          $name_error = "Sorry... username already taken"; 
          //echo $name_error;	
        }else if(mysqli_num_rows($res_e) > 0){
          $email_error = "Sorry... email already taken"; 	
          //echo $email_error;
        }elseif ($_POST["pass"] !== $_POST["cpass"]){
          $cpassErr= "password not match";
          
        }
        else{
          //echo "done";
          $sql = "INSERT INTO user (firstname,lastname,email,username,pass,cpass,bio,img)
                    VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[uname]','$_POST[pass]','$_POST[cpass]','$_POST[bio]','$target_file')";
  
            if (mysqli_query($conn, $sql)) {
              
              echo  "New record created successfully !";
              
            } else {
              echo "Error: " . $sql . " " . mysqli_error($conn);
              
            }
            
        }
        $conn->close();
      }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="container">
  <h2> Demo  </h2> <br>
<p><span class="error">* Field is Required </span></p>

<form name="demo" id="demo" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" >  
<div class="form-group">

    <label for="Name">First Name:</label>
    <span class="error">* <?php echo $fnameErr; ?> </span>  <br>
    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" value="<?php echo $fname;  ?>" required >
    
    
    <label for="Name">Last Name:</label>
    <span class="error">* <?php echo $lnameErr; ?> </span>  <br> 
    <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $lname; ?>" required>
    
    
    <label for="Name">User Name:</label>
    <span class="error">* <?php echo $unameErr.$name_error; ?> </span> <br>
    <input type="text" name="uname" class="form-control" placeholder="User Name" value="<?php echo $uname; ?>"  required>
    

    <label for="email">Email:</label>
    <span class="error">* <?php echo $emailErr.$email_error; ?> </span>  <br>
    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email;  ?>"  required >
     
    
    <label for="password">Password:</label>
    <span class="error">* <?php echo $passErr; ?> </span><br>
    <input type ="password" name="pass" class="form-control" placeholder="Password"  required >
    
    
    <label for="Conform Password">Conform Password:</label>
    <span class="error">* <?php echo $cpassErr; ?> </span><br>
    <input type ="password" name="cpass" class="form-control" placeholder="Conform Password" required>
    
    
    <label for="Name">Bio:</label>
    <textarea name="bio" rows="5" cols="40" class="form-control" placeholder="Text Area" > <?php echo $bio;  ?></textarea><br>
    
    <label for="Name">Profile Pic:</label>
    <span class="error">* <?php echo $imgErr ?> </span><br>
    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required >  

    <?php echo "<br>"; ?>
    <input type="submit" name="submit" class="btn btn-primary btn-floating mx-1" value="Submit" onclick= "clear()"  > 
</div>
</form>


</div>
<script type="text/JavaScript">
  function clear(){
    document.getElementById('demo').reset();
  }
</script>

</body>
</html>
