<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PlUTO: Picture Managment</title>
</head>
<body class = "plutoBackground">

 <?php
 include "adminNavigation.php";
 
 require_once "config.php";
            
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   
    $sql = "SELECT * FROM Pictures";
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$pod=null;
?>

<table class="tables">
<tr><th colspan="5"><h1>PlUTO: Picture Managment</h1></th></tr>
<tr><td><?php include "addPic.php" ?></td>
<?php
$count = 0;
//print pictures in rows of 5 cols 
while($row = $statement->fetch())
	{
		if($count < 4)
		{
			echo"<td><a href='editPic.php?id=".$row["PictureID"]."'><img src='images/".$row["FileName"]."' class='galleryImages'></a></td>";
		}
		else if($count == 4)
		{
			echo"</tr><tr>";
			echo"<td><a href='editPic.php?id=".$row["PictureID"]."'><img src='images/".$row["FileName"]."' class='galleryImages'></a></td>";
		}
		
		if($count > 4 && $count < 9)
		{
			echo"<td><a href='editPic.php?id=".$row["PictureID"]."'><img src='images/".$row["FileName"]."' class='galleryImages'></a></td>";
		}
		else if($count == 9)
		{
			echo"</tr><tr>";
			echo"<td><a href='editPic.php?id=".$row["PictureID"]."'><img src='images/".$row["FileName"]."' class='galleryImages'></a></td>";
			$count = 4;
		}	
		$count += 1;
	}
		echo"</tr>";
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