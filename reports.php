<!DOCTYPE html>
<?php
 include "checkLogin.php";
$printUserReport = false;
$printShowReport= false;
	require_once "config1.php";       
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	if(isset($_POST["userReport"]))
	{
		$sql = "SELECT LastName, Email, COUNT(TicketID) AS TotalTickets, SUM(Attended) AS TotalAttended, SUM(Canceled) AS TotalCanceled
				FROM Users
				INNER JOIN Tickets
				ON Users.UserID = Tickets.UserID
				GROUP BY Email
				ORDER BY TotalTickets DESC";		
		$statement = $pdo->prepare($sql);
		$statement->execute();
		$printUserReport = true;
	}
	if(isset($_POST["showingsReport"]))
	{
		$sql = "SELECT Title, 'Reserved Ticket' AS 'Ticket Type', COUNT(TicketID) AS 'Number of Tickets'
    FROM Shows
    JOIN Showings
        ON Shows.showID = Showings.showID
    JOIN Tickets
        ON Showings.showingID = Tickets.showingID
    WHERE Tickets.UserID != 10
    GROUP BY Title
UNION
SELECT Title, 'Unreserved Ticket' AS 'Ticket Type', COUNT(TicketID)  AS 'Number of Tickets'
    FROM Shows
    JOIN Showings
        ON Shows.showID = Showings.showID
    JOIN Tickets
        ON Showings.showingID = Tickets.showingID
    WHERE Tickets.UserID = 10
    GROUP BY Title
    ORDER BY Title, 'Ticket Type' DESC";
		$statement = $pdo->prepare($sql);
		$statement->execute();
		$printShowReport= true;
	}
		
?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PLUTO: Reoprts</title>
</head>
<body class = "plutoBackground">
<?php  include "adminNavigation.php"; ?>
<div class=tables>
<h1>PlUTO: Reports</h1> 
<form action="reports.php" method="POST">
<button type="submit" name="userReport">Generate User Report</button> &emsp; <button type="submit" name="showingsReport">Generate Showings Report</button>
</form>
</div>
<br><br>
<?php
if ($printUserReport)
{
echo "<div class='tables'><table align='center' border = 2px><tr><th>Name</th><th>E-Mail</th><th>Toral Tickets</th><th>Attended</th><th>Cancled</th></tr>";
while($results = $statement->fetch())
{
	echo "<tr><td>".$results["LastName"]."</td>
	<td>".$results["Email"]."</td>
	<td>".$results["TotalTickets"]."</td>
	<td>".$results["TotalAttended"]."</td>
	<td>".$results["TotalCanceled"]."</td></tr>";
}
echo "</table></div>";
}
if ($printShowReport)
{
echo "<div class='tables'><table align='center' border = 2px><tr><th>Title</th><th>Type</th><th>Num Reservations</th></tr>";
while($results = $statement->fetch())
{
	echo "<tr><td>".$results["Title"]."</td>
	<td>".$results["Ticket Type"]."</td>
	<td>".$results["Number of Tickets"]."</td></tr>";
}
echo "</table></div>";
}

?>

</body>
</html>
<?php
$pdo=null;

		}
	catch (PDOException $e) {
		die( $e->getMessage() );
		}
?>