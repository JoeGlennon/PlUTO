<!DOCTYPE html>
<?php 
session_start(); 
include "cancelTicket.php" ?>
<html>
<head class = "plutoBackground">
<title>PlUTO Home Page</title>
<link rel="stylesheet" href="lookPretty.css" />
</head>
	<body class = "plutoBackground">

  <?php  
  include "adminNavigation.php";
  if(!isset($_POST["cancelTicket"])){
	require_once "config.php";
  }

  try {
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      $sql = "SELECT Shows.Title, Shows.Description, Shows.Duration, Showings.ShowingID, 
		TIME_FORMAT(Showings.Time, '%h:%i %p') AS Time, DATE_FORMAT(Showings.Date,'%b %D %Y') AS Date, 
		Showings.SeatsAvalible, Pictures.FileName, Pictures.Description AS altPic
		FROM Showings 
		INNER JOIN Shows 
		ON Shows.ShowID = Showings.ShowID
		LEFT JOIN ShowsPictures
		ON Shows.ShowID = ShowsPictures.ShowID
		LEFT JOIN Pictures
		ON ShowsPictures.PictureID = Pictures.PictureID
		WHERE Showings.Date >= CURDATE() AND (Pictures.PictureID IS NULL OR Pictures.PictureID = (SELECT MIN(PictureID) FROM ShowsPictures s2 WHERE s2.ShowID = ShowsPictures.ShowID))
		ORDER BY Showings.Date, Showings.Time";
	$statement = $pdo->prepare($sql);	
	$statement->execute();
	
	    $pdo=null;
  ?>
  <table class = "tables">
		<tr><th colspan="4"><h1>Upcoming Showings</h1></th></tr>
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
				//chech if showing has a picture
				if($row["FileName"] != NULL)
				{
					echo "<tr><td colspan='2' align = 'center'><img src='images/".$row["FileName"]."' alt='".$row["altPic"]."' class = 'upcomingShowingPic'></td></tr>";
				}
				echo "<tr><td>Date: ".$row["Date"]."</td><td>Show Time:".$row["Time"]."</td></tr>";
				echo "<tr><td>Length: ".$row["Duration"]." min </td><td>Remaining Seats: ".$row["SeatsAvalible"]."</tr>";
				echo "<tr><td colspan='2'>".$row["Description"]."</td></tr>";
				if ($row["SeatsAvalible"] <= 0)
				{
					echo "<tr><td colspan = '2'><b>Showing Full</b></td></tr>";
				}
				else
				{
					echo "<tr><td colspan = '2'><button type='button'><a href='reserveTicket.php?id=".$row["ShowingID"]."'>Reserve Tickets</a></button></td></tr>";
				}
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
<div class="userCancelReservation">
<h2>Cancel Reservation</h2>
<form action="index.php" method="POST">
	<?php include 'errors.php' ?>
    <label for="userEmail">Email:</label><br>
    <input type="text" id="userEmail" name="userEmail"><br><br>
    <label for="userTicketNum">Ticket Number:</label><br>
    <input type="text" id="userTicketNum" name="userTicketNum"><br><br>
	<button type="submit" class="btn" name="cancelTicket">Cancel Reservation</button>
</form>
</div>
<?php if($mailSent)
{
	echo "<p>A verifiction email has been sent</p>";
}
?>
    </body>
</html>
