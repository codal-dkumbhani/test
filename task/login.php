<!DOCTYPE HTML>  
<html>
  <head>
  <title>LOGIN </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
    .error {color: #FF0000;}
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
<body> 

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
  //variable define
  $username = $password = $id=  "";
  if(!empty($_POST)){
  $username = $_POST["username"]; 
  $password = $_POST["password"]; 
  }
  //echo $username;

  $records = mysqli_query($conn,"select * from user");
  while($data = mysqli_fetch_array($records))
  {
    if($data['username']==$username & $data['pass']==md5($password)){
      //echo $data['id'];
      $_SESSION['id'] = $data['id'];
    }
  } 

    //to prevent from mysqli injection  
  $username = stripcslashes($username);  
  $password = stripcslashes($password);  
  $username = mysqli_real_escape_string($conn, $username);  
  $password = mysqli_real_escape_string($conn, $password);  
  
    $password = md5($password);
    $sql = "select * from user WHERE username = '$username' and pass = '$password'";  
    $result = mysqli_query($conn, $sql);    
    $count = mysqli_num_rows($result);  
    
    $sql = "SELECT * FROM user ";
    $result = $conn->query($sql);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {


      //google recaptcha validation
    if(isset($_POST['g-recaptcha-response']))
        $captcha=$_POST['g-recaptcha-response'];
        //echo $captcha;
        if(!$captcha){
            echo '<div class="alert alert-danger" role="alert"> Verify recaptcha First.</div>';
            //exit;
        }

        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LciwlgaAAAAAPH_3RLiSHrkPVFa6MTX0d0qECOo&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false)
        {
          echo '<div class="alert alert-danger" role="alert"> You are spammer !</div>';  
        }
        else{
          if($count == 1){  
            echo '<div class="alert alert-success" role="alert"> Login successful </div>';
            echo '<div class="alert alert-success" role="alert"> >Thanks for Login </div>';
            $_SESSION["loggedin"] = true;  
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              $_SESSION['username'] =  $username;
              $_SESSION['password'] = $_POST['password'];
              $_SESSION['userId'] = $row["id"];
            }
          }  
          else{  
            echo '<div class="alert alert-danger" role="alert"> Login failed. Invalid username or password. </div>';
          }   
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: edit.php");
            exit;
          }
        }
        
  }


?>
<div class="container">
<form name="edit" id="edit" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"  >
<div class="form-group">
<h2>Login</h2>

<label for="Name">User Name:</label>
<input type="name" name="username" id="username" class="form-control" required>

<label for="pass">Password:</label>
<input type="password" name="password" id="password" class="form-control" required ><br>

<div class="g-recaptcha" data-sitekey="6LciwlgaAAAAAG2W3vGVcl9yLsSsvwYc0l21qNtr"></div> <br>

<input type="submit" name="submit" id="submit" class="btn btn-primary btn-floating mx-1"  value="submit">

</form>