<!DOCTYPE html>
<?php
 include "checkLogin2.php";
$errors = array();
if(isset($_POST['checkIn']))
{
	$tixNum = $_POST['ticketNumber'];
	if(empty($tixNum))
	{
	array_push($errors, "Ticket Number Required");
	}
	
	if (count($errors) == 0) 
  {
	require_once "config1.php";       
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//check if is BlankUser
		$tixAry = str_split(str_pad($tixNum,12,"0",STR_PAD_LEFT), 2);
		if($tixAry[3] == "00" && $tixAry[4] == "10")
		{
			//update blank ticket number of seats
			$sql = "UPDATE Tickets
					SET NumSeats = NumSeats + 1
					WHERE TicketNum = :tnm";
		}
		else
		{
			//update users ticket
			$sql = "UPDATE Tickets 
					SET Attended = 1 
					WHERE TicketNum = :tnm";
		}	
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':tnm', $tixNum);
		$statement->execute();
		if($statement->rowCount())
		{
			array_push($errors, "Check in successful!");
		}
		else
		{
			array_push($errors, "Failed to check in.");
		}

		$pdo=null;

		}
	catch (PDOException $e) {
		die( $e->getMessage() );
		}
  }
}
?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PLUTO:Check In</title>
</head>
<body class = "plutoBackground">
<?php  include "adminNavigation.php"; ?>
<div class=tables>
<h1>PlUTO: Check In</h1> 
<?php include('errors.php'); ?>
<form action="checkIn.php" method="POST">
Enter Ticket Number(Should be 11 digits)
<input type=number name=ticketNumber placeholder="00000000000">
<br><br>
<button type="submit" name="checkIn">Check In</button>
</form>
</div>
<?php

require_once "config1.php";       
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 $sql = "SELECT Showings.Time, Shows.Title, Tickets.TicketNum FROM Showings 
		INNER JOIN Shows 
		ON Shows.ShowID = Showings.ShowID 
		INNER JOIN Tickets
		ON Tickets.ShowingID = Showings.ShowingID
		INNER JOIN Users
		ON Users.UserID = Tickets.UserID
		WHERE Showings.Date = CURDATE() AND Users.UserID = 10
		ORDER BY Showings.Date";
		$statement = $pdo->prepare($sql);
		$statement->execute();
		?>
		<div id = "noResBarcodes">
		<br>
		<div class = "tables">
		<h4>No Reservations Barcodes</h4>
		<?php
		$count = 0;
		while ($row = $statement->fetch())
		{
		echo "<p><b>".$row["Title"]."</b><br>".$row["Time"]."</p><img src='images/barcodes/".$row["TicketNum"].".png' alt='".$row["TicketNum"]."'><br>";
		$count = $count +1;
		}
		if($count<1)
		{
			echo "<p>No showings today</p>";
		}
		?>
		</div>
		</div>
		<?php
		$pdo=null;

		}
	catch (PDOException $e) {
		die( $e->getMessage() );
		}
?>

