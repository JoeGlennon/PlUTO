<!DOCTYPE html>
<html>
<head>
<title>WARNING!</title>
<link rel="stylesheet" href="lookPretty.css" />
</head>
<body class = "plutoBackground">
<?php  
include "checkLogin.php";
include "adminNavigation.php"; 
?>
<div class="tables">
<h1>WARNING!</h1>
<h2>You are about to delete <?php echo $_GET["title"]; ?></h2>
<h3>If you continue all records of <b style="color:red;">tickets</b> and <b style="color:red;">showings</b> connected to <?php echo $_GET["title"]; ?> will be <b style="color:red;">perminatly deleted</b></h3>
<br><br><br>
<a href="deleteShow.php?id=<?php echo $_GET["id"]; ?>" class="dangerLink">Confirm Delete</a>
</div>
</body>
</html>