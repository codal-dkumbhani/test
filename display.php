<?php

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


<html>
<head>
  <title>Fetch image from database in PHP</title>
</head>
<body>

<h2>All Records</h2>

<table border="2">
  <tr>
    <td>Sr.No.</td>
    <td>First Name</td>
    <td>Last Name</td>
    <td>Email</td>
    <td>User Name</td>
    <td>BIO</td>
    <td>Images</td>
  </tr>

<?php

//include "dbConn.php"; // Using database connection file here

$records = mysqli_query($conn,"select * from user"); // fetch data from database

while($data = mysqli_fetch_array($records))
{
?>
  <tr>
    <td><?php echo $data['id']; ?></td>
    <td><?php echo $data['firstname']; ?></td>
    <td><?php echo $data['lastname']; ?></td>
    <td><?php echo $data['email']; ?></td>
    <td><?php echo $data['username']; ?></td>
    <td><?php echo $data['bio']; ?></td>
    <td><img src="<?php echo $data['img']; ?>" width="100" height="100"></td>
  </tr>	
<?php
}
?>

</table>

<?php mysqli_close($db);  // close connection ?>

</body>
</html>