<?php
require_once "session.php";
require_once "connection.php"
?>


<html>
<head>
  <title>Display Data</title>
</head>
<body>
<center>
<h2>All Records</h2>


<form  name="filterform" id="filterform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <select name="filter" id="filter" onchange='this.form.submit()' >
        <option value="Select" >Select</option>
        <option value="ascending order">Ascending order</option>
        <option value="descending order">Descending order</option>
    </select>
    
</form>


<table border="2">
  <tr>
    <td>Sr.No.</td>
    <td>First Name</td>
    <td>Last Name</td>
    <td>Email</td>
    <td>User Name</td>
    <td>BIO</td>
    <td>Images</td>
    <td>Edit Data</td>
  </tr>
  </center>
<?php
$filter="";   
if(!empty($_POST)){
  $filter = $_POST['filter'];
}
if($filter == 'ascending order'){
  $records = mysqli_query($conn,"select * from user ORDER BY firstname ASC"); // fetch data from database

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
        <td><img src="<?php echo $data['img']; ?>" width="200" height="150"></td>
        <td><a href="login.php">  Edit</a></td>
      </tr>	
    <?php
    }  
}
else {
  $records = mysqli_query($conn,"select * from user ORDER BY firstname DESC"); // fetch data from database

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
        <td><img src="<?php echo $data['img']; ?>" width="200" height="150"></td>
        <td><a href="login.php">  Edit</a></td>
      </tr>	
    <?php
    } 
}

?>

</table>



</body>
</html>


