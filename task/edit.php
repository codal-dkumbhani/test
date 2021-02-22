<html>
<head>
<title>Edit FORM</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </script>
    <style>
    .error {color: #FF0000;}
    </style>

<?php
require_once "session.php";
require_once "connection.php";



$fnameErr = $lnameErr = $unameErr = $name_error = $emailErr = $email_error ="";

$user = $_SESSION['username'];
$password = $_SESSION['password'];
$id = $_SESSION['id'];

if(isset($_POST["submit"])) {

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

  if (empty($_POST["uname"])) {
    $unameErr = "User Name is required";
  } else {
      $uname = test_input($_POST["uname"]);
      if (!preg_match("/^[0-9a-zA-Z-' ]*$/",$uname)) {
        $unameErr = "Only letters & Number & white  space allowed Special char NOT allowed ";
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
  if($fnameErr == "" && $lnameErr == "" && $unameErr == "" && $emailErr == "" && $name_error == "" && $email_error == ""){

    $sql = "UPDATE user SET firstname = '$_POST[fname]',lastname = '$_POST[lname]', username ='$_POST[uname]', email = '$_POST[email]', bio ='$_POST[bio]' WHERE id = $id ";
          if (mysqli_query($conn, $sql)) {
              echo '<div class="alert alert-success" role="alert"> New record created successfully !</div>';
              
            } else {
              echo "Error: " . $sql . " " . mysqli_error($conn);
            }
  }
}

function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }



        
        
  $sql = "SELECT * from user where id=$id";
$rs = mysqli_query($conn, $sql);
//  $result =mysqli_num_rows($result);
while($row = mysqli_fetch_array($rs)) {
      // Write the value of the column FirstName (which is now in the array $row)
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $username = $row['username'];
    $email = $row['email'];
    $bio = $row['bio'];
    
  }

  



?>
<div class="container">
<form name="demo" id="demo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"  >
<div class="form-group">
<h2>Details</h2>
    <label for="Name">First Name:</label>
    <span class="error">* <?php echo $fnameErr; ?> </span>  <br>
    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" value="<?php echo $firstname;  ?>" required ><br>

    
    <label for="Name">Last Name:</label> 
    <span class="error">* <?php echo $lnameErr; ?> </span>  <br> 
    <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $lastname; ?>" required><br>
    
    
    <label for="Name">User Name:</label>
    <span class="error">* <?php echo $unameErr; ?> <?php echo $name_error; ?> </span> <br>
    <input type="text" name="uname" class="form-control" placeholder="User Name" value="<?php echo $username; ?>"  required><br>
    

    <label for="email">Email:</label>
    <span class="error">* <?php echo $emailErr.$email_error; ?> </span>  <br>
    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email;  ?>"  required ><br>
     
    <label for="bio">Bio:</label>
      <textarea name="bio" rows="5" cols="40" class="form-control" placeholder="Bio" ><?php echo $bio; ?></textarea><br>
   

      <input type="submit" name="submit" class="btn btn-primary btn-floating mx-1" onClick="window.location.reload();" value="Submit">



<a href="display.php" class="btn btn-primary btn-floating mx-1" onclick="display()"  >Display All data</a>

<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>

</form>

