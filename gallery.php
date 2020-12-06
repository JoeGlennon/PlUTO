<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PlUTO: Gallery</title>
</head>
<body class = "plutoBackground">

<?php
 session_start(); 
 include "adminNavigation.php";
 
 require_once "config.php";
            
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   
    $sql = "SELECT * FROM Pictures";
	$statement = $pdo->prepare($sql);
	$statement->execute();

?>
<table class = "tables">
<tr><th colspan="5"><h1>Picture Gallery</h1></th></tr>
<?php
$count = 0;
//print pictures in rows of 5 cols 
while($row = $statement->fetch())
	{
		if($count == 0)
		{
			echo"<tr>";
		}
		if($count < 5)
		{
			echo"<td style = 'border: 5px solid black; border-radius: 5px; border-spacing: 10px;'><img src='images/".$row["FileName"]."' alt='".$row["Description"]."' class='galleryImages'></td>";
		}
		else if($count == 5)
		{
			echo"</tr><tr>";
			echo"<td style = 'border: 5px solid black; border-radius: 5px; border-spacing: 10px;'><img src='images/".$row["FileName"]."' alt='".$row["Description"]."' class='galleryImages'></td>";
			$count = 0;
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