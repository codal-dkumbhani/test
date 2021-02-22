<!DOCTYPE HTML>  
<html>
  <head>
    <title>DEMO FORM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/JavaScript">



    /*  jQuery(document).ready(function($) {
      $('#demo').submit(function(event){
          event.preventDefault();
      //alert('yes');
      this.reset();
      });
      });
    
   /* alert('ok');
      function clear(e){
        e.preventDefault();
        alert('test');
        document.getElementById('demo').reset();
        return false;
      }*/
    </script>
    <style>
    .error {color: #FF0000;}
    </style>

  </head>
<body>  
<?php
 
 
$target_file ="";
$name="";
$ip=$_SERVER['REMOTE_ADDR'];
  

  //image part
  $target_dir = "upload/";
  if(!empty($_FILES)){
  $name =  htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))."<br>";}
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  if(!empty($_POST)){
  $name = $_POST['uname'] .$imageFileType ;}
  $target_file = $target_dir . $name ;

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
      /*
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
    }*/
  }




        
  //condition check part
  $fnameErr = $lnameErr = $emailErr = $unameErr = $passErr = $cpassErr = $name_error = $email_error = $bdateErr = $pnumberErr = $addErr = $zipErr = $imgErr ="";
  $fname = $lname = $email = $uname = $pass = $cpass = $pnumber =  "";

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

    if (empty($_POST["bdate"])) {
      $bdateErr = "Birthday Date is required";
    }else{
      $dob = $_POST['bdate'];
  
        $date1 = $dob;
        $date2 = date('Y-m-d');
        
        $diff = abs(strtotime($date2) - strtotime($date1));
        
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo '<div class="alert alert-success" role="alert">'. $years ."&nbspYears,&nbsp" . $months ."&nbspMonths,&nbsp" . $days ."&nbspDays". '</div>';
    }

        if(!empty($_POST["pnumber"])) // phone number is not empty
         {
            if(preg_match('/^[1-9][0-9]{10}$/',$pnumber)) // phone number is valid
            {
              $pnumber = '0' . $pnumber;
            }
            else // phone number is not valid
            {
              $pnumberErr = 'Phone number invalid !';
            }
          }
        else // phone number is empty
        {
          $pnumberErr = 'You must provid a phone number !';
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
      } else {
          // failed 
          $cpassErr = "password not match";
    } 

    if (empty($_POST["address"])) {
      $addErr = "Address is required";
    } 

    if (empty($_POST["zip"])) {
      $zipErr = "Zip code is required";
    } else {
        $zip = test_input($_POST["zip"]);
        if (!preg_match("/[0-9]{5}/",$zip)) {
          $zipErr = "Enter valied Zip code ";
        }
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
              data_submit date,
              ip varchar(30),
              firstname VARCHAR(30) NOT NULL,
              lastname VARCHAR(30) NOT NULL,
              email VARCHAR(100) NOT NULL, 
              username VARCHAR(10) NOT NULL,
              pass VARCHAR(100) NOT NULL,
              cpass VARCHAR(100) NOT NULL,
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
            //image transfer in directory 
            if ($uploadOk == 0) {
              $imgErr = "Sorry, your file was not uploaded.";
              //echo '<script>alert("Sorry, your file was not uploaded.")</script>'; 
              //echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  echo '<div class="alert alert-success" role="alert">The file '. htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])).'" has been uploaded.<br></div>';
                  //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>";
                } else {
                  echo "Sorry, there was an error uploading your file.<br>";
                }
            }
            $_POST['pass'] = md5($_POST['pass']);
            $_POST['cpass'] = md5($_POST['cpass']);
            //echo "done";
            $sql = "INSERT INTO user (data_submit,ip,firstname,lastname,email,username,pass,cpass,bio,img)
                      VALUES ( NOW(),'$ip','$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[uname]','$_POST[pass]','$_POST[cpass]','$_POST[bio]','$target_file')";
    
              if (mysqli_query($conn, $sql)) {
                echo '<div class="alert alert-success" role="alert"> New record created successfully !</div>';
              // echo  "New record created successfully !";
                
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

<form name="demo" id="demo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"  >  
<div class="form-group">

    <label for="Name">First Name:</label>
    <span class="error">* <?php echo $fnameErr; ?> </span>  <br>
    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" value="<?php echo $fname;  ?>" required >

    
    <label for="Name">Last Name:</label>
    <span class="error">* <?php echo $lnameErr; ?> </span>  <br> 
    <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $lname; ?>" required>
    
    
    <label for="Name">User Name:</label>
    <span class="error">* <?php echo $unameErr; ?> <?php echo $name_error; ?> </span> <br>
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

    <label for="Birthdate">Birth Date:</label>
    <span class="error">* <?php echo $bdateErr; ?> </span><br>
    <input type ="date" name="bdate" class="form-control"  required>
    
    <label for="Contact">Contact No:</label>
    <span class="error">* <?php echo $pnumberErr; ?> </span><br>
    <input type ="text" name="pnumber" class="form-control" placeholder="Contact number"   required>

    <label for="Name">Address:</label>
    <span class="error">* <?php echo $addErr ?> </span><br>
    <textarea name="address" rows="5" cols="40" class="form-control" placeholder="Address" required ></textarea><br>

    <label for="zipcode">Zip code:</label>
    <span class="error">* <?php echo $zipErr; ?> </span><br>
    <input type ="text" name="zip" class="form-control" placeholder="Zip Code"   required><br>

    <label for="country"> Select Country:<span class="error">*  </span></label>
    <select name="country" id="countySel" size="1" class="form-control"  required>
      <option value="" selected="selected">Select Country</option>
      </select>
      <br>
      <br>
      <label for="state">Select State: <span class="error">* </span></label>
      <select name="state" id="stateSel" size="1" class="form-control" required>
      <option value="" selected="selected">Select State</option>
      </select>
      <br>
      <br>
      <label for="city">Select city:  <span class="error">*  </span></label>
      <select name="city" id="districtSel" size="1" class="form-control" required>
      <option value="" selected="selected">Select City</option>
      </select><br>
    
      <label for="bio">Bio:</label>
      <textarea name="bio" rows="5" cols="40" class="form-control" placeholder="Bio" ></textarea><br>
      
      <label for="Name">Profile Pic:</label>
      <span class="error">* <?php echo $imgErr ?> </span><br>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" onchange="showMyImage(this)" required >  <br>
      <img id="thumbnil" style="width:100%; max-width: 500px; margin:10px 0; display:none;"  src="" alt="logo"/>

      <input type="submit" name="submit" class="btn btn-primary btn-floating mx-1" value="Submit"  onsubmit="return clear(this);"  > &nbsp;&nbsp;&nbsp;&nbsp;
      <input name="edit" type="button" value="Edit Data" class="btn btn-primary btn-floating mx-1" onclick="window.open('login.php')"/>
      
      
</div>
</form>
<script>
function showMyImage(fileInput) {
      var files = fileInput.files;
        //console.log(files);
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            console.log(file.name);
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("thumbnil");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
            thumbnil.style.display = 'block';
            //$("#banner_name").text(file.name);

        }
  }
</script>
<script>



    var stateObject = {
    "India": { "Gujrat": ["Ahmedabad", "Surat", "Mehsana", "Vadodra", "Amreli"],
    "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Nashik" ],
    "Delhi": ["New Delhi", "Firozabad", "Shergarh"],
    },
    "Australia": {
    "South Australia": ["Sydny", "perth", "Hobart"],
    "Victoria": ["Melbourne", "Geelong", "Ballarat"],
    "New South Wales": ["Albury-Wodonga", "Armidale", "Ballina"]
    }, "Canada": {
    "Alberta": ["Edmonton", "Fort Saskatchewan" ,"Grande Prairie"],
    "Columbia": ["Bogota", "Leticia"],
    "Manitoba": ["Winnipeg", "Brandon", "Steinbach"]
    },
    }
    window.onload = function () {
        var countySel = document.getElementById("countySel"),
        stateSel = document.getElementById("stateSel"),
        districtSel = document.getElementById("districtSel");
        for (var country in stateObject) {
          countySel.options[countySel.options.length] = new Option(country, country);
      }
        countySel.onchange = function () {
          stateSel.length = 1; // remove all options bar first
          districtSel.length = 1; // remove all options bar first
          if (this.selectedIndex < 1) return; // done
          for (var state in stateObject[this.value]) {
              stateSel.options[stateSel.options.length] = new Option(state, state);
          }
      }
        countySel.onchange(); // reset in case page is reloaded
        stateSel.onchange = function () {
          districtSel.length = 1; // remove all options bar first
          if (this.selectedIndex < 1) return; // done
          var district = stateObject[countySel.value][this.value];
          for (var i = 0; i < district.length; i++) {
            districtSel.options[districtSel.options.length] = new Option(district[i], district[i]);
          }
      }
    }
  </script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</div>

</body>
</html>
