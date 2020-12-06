<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
</head>
<?php
include "checkLogin.php";
require_once "config1.php";
include "adminNavigation.php";
try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT Email, LastName, TicketNum, NumSeats
			FROM Users
			INNER JOIN Tickets
			ON Users.UserID = Tickets.UserID
			WHERE Tickets.ShowingID = :sid AND Tickets.Canceled = 0";

    $statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
    $statement->execute();
	$numRows = $statement->rowCount();
	
	//if users already have reservations to showing
	if($numRows > 1)
	{
		//display users who have reservations for show you want to cancel
		echo "<table class ='tables'><tr><th colspan='4'>Existing ".$_GET["title"]." Reservations</th></tr>";
		echo "<tr><th>Email</th><th>Last Name</th><th>Ticket Number</th><th>Seats</th></tr>";
		while ($row = $statement->fetch())
		{
			echo "<tr><td>".$row["Email"]."</td><td>".$row["LastName"]."</td><td>".$row["TicketNum"]."</td><td>".$row["NumSeats"]."</td></tr>";
		}	
		echo "</table>";
		echo"<br><div align='center'><p>The above users alrady have reservations for the showing you are tyring to cancel. <br>If you wish to continue the above users will be notified of the cancelation.<br>";
		echo "The following message will be sent to the users.<br> If you wish to change the message, just update the text in the box.</p>";
		
		echo "<form action='deleteTicketsShowing.php?id=".$_GET["id"]."' method='POST'>";
		echo "<textarea name='message' spellchack='true' style='margin: 5px; width: 350px; height: 100px;'><p>Dear Planetarium Patron,<br> We regret to inform you that your reservation for ".$_GET["title"]." on ".$_GET["date"]." at ".$_GET["time"];
		echo " has been canceled due to the showing being canceled. <br> Thank you for understanding,<br>Heitkamp Planetarium Staff</p></textarea><br>";
		echo "<button type='submit' name='cancelConfirm'>Confirm Showing Cancelation</button></form></div>";
		 	
	}
	//no reservations have been made for showing yet and can be deleted
	else
	{
		//delete blankUserTicket
		$sql = "DELETE FROM Tickets
				WHERE UserID = 10 AND ShowingID = :sid";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':sid', $_GET["id"]);
		$statement->execute();
		
		//delete showing
		$sql = "DELETE FROM Showings
				WHERE ShowingID = :sid";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':sid', $_GET["id"]);
		$statement->execute();
		
		//nav back to admin home page
		header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
	}
		
	
	$pdo=null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>

</body>
</html>