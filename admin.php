<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head class = "plutoBackground">
<title>PlUTO Managment</title>
<link rel="stylesheet" href="lookPretty.css" />
</head>
	<body class = "plutoBackground">
  <?php  
  include "adminNavigation.php";
  require_once "config.php"; 

  try {
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  
	$sql = "SELECT Shows.Title, Shows.Description, Shows.Duration, Showings.ShowingID, 
		TIME_FORMAT(Showings.Time, '%h:%i %p') AS Time, DATE_FORMAT(Showings.Date,'%b %D %Y') AS DateFormated, Showings.Date, 
		Showings.SeatsAvalible, Pictures.FileName, Pictures.Description AS altPic
		FROM Showings 
		INNER JOIN Shows 
		ON Shows.ShowID = Showings.ShowID
		LEFT JOIN ShowsPictures
		ON Shows.ShowID = ShowsPictures.ShowID
		LEFT JOIN Pictures
		ON ShowsPictures.PictureID = Pictures.PictureID
		WHERE (Pictures.PictureID IS NULL OR Pictures.PictureID = (SELECT MIN(PictureID) FROM ShowsPictures s2 WHERE s2.ShowID = ShowsPictures.ShowID))
		ORDER BY Showings.Date, Showings.Time";
	$statement = $pdo->prepare($sql);	
	$statement->execute();
	
	    $pdo=null;
  ?>
   
  <table class = "tables">
   
   <tr><th colspan="3"><h1>PlUTO: Homepage Managment</h1></th></tr>
		<tr><th colspan="3"><h2>All Showings</h2></th></tr>
  <?php 
		$count=0;
		$numRows = 0;
 	  while($row = $statement->fetch())
	      {	
			
			$numRows++;
			if($count == 0)
			{
				echo"<tr>";
			}
			if($count < 3 )
			{
				echo "<td style = 'border: 5px ridge #442D7D; border-radius: 10px;'>";
				echo "<table class='upcomingShowing'>";
				echo "<tr class = 'upcomingShowText'><th colspan='2'>".$row["Title"]."</th></tr>";
				if($row["FileName"] != NULL)
				{
					echo "<tr><td colspan='2' align = 'center'><img src='images/".$row["FileName"]."' alt='".$row["altPic"]."' class = 'upcomingShowingPic'></td></tr>";
				}
				echo "<tr><td>Date: ".$row["DateFormated"]."</td><td>Show Time:".$row["Time"]."</td></tr>";
				echo "<tr><td>Length: ".$row["Duration"]." min </td><td>Remaining Seats: ".$row["SeatsAvalible"]."</tr>";
				echo "<tr><td colspan='2'>".$row["Description"]."</td></tr>";
				if ($row["Date"] < date("Y-m-d"))
				{
					echo "<tr><td colspan = '2'><b>Showing Complete</b></td></tr>";
				}
					echo "<tr><td colspan = '2'><button type=button><a href='editShowing.php?id=".$row["ShowingID"]."'>Edit Showing</a></button></td></tr>";
				echo "</table>";
				echo "</td>";
				$count++;
				if($count == 3)
				{
					echo "</tr>";
					$count = 0;
				}
		
			}
		  }
		if( $numRows < 1)
		{
			echo "<tr><td>No Showings Avalible</td></tr>";
		}
?>

</table>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}

?>

    </body>
</html>