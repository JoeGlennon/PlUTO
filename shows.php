<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PlUTO: Shows Managment</title>
</head>
<body class = "plutoBackground">

 <?php
 include "adminNavigation.php";
 
 require_once "config.php";
            
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT ShowID, Title, Duration, Description FROM Shows ORDER BY Title";
	$statement = $pdo->prepare($sql);
    $statement->execute();

?>
<table class = "tables">
<tr><th colspan="3"><h3 align ="center">PlUTO: Shows Managment</h3></th></tr>
<tr><td colspan="3"><button type="button"><a href="addShow.php">Create a New Show</a></button></td></tr>
<?php 
$count=0;
while($row = $statement->fetch())
	{
		if($count==0)
		{
			echo "<tr>";
		}
		if($count < 3)
		{
			echo "<td style = 'border: 5px ridge #442D7D; border-radius: 10px;'>";
			echo "<table width='325'>";
			echo "<tr><td colspan='2'><a href='editShow.php?id=".$row["ShowID"]."'>".$row["Title"]."</a></td></tr>";
			echo "<tr><td colspan='2'>Duration: ".$row["Duration"]." min</td></tr>";
			echo "<tr><td colspan='2' style='wordwrap: break-word;'>".$row["Description"]."</td></tr>";
			echo "<tr><td><button type='button'><a href='editShow.php?id=".$row["ShowID"]."'>Edit Show</a></button></td>"; 
			echo "<td><button type='button'><a href='addShowing.php?id=".$row["ShowID"]."'>Create Showing</a></button></td></tr>";
			echo "</table>";
			echo "</td>";
			$count++;
		}
		if($count == 3)
		{
			echo "</tr>";
			$count = 0;
		}
	}
?>
</table>



</body>
</html>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>