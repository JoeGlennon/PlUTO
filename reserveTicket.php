<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>PLUTO: Reservatiion Form</title>
</head>
<body class = "plutoBackground">
<?php
 include "adminNavigation.php";
 require_once "config.php";  
 try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET["id"];
    $sql = "SELECT Showings.ShowingID, Showings.Capacity, Showings.SeatsAvalible, TIME_FORMAT(Showings.Time, '%h:%i %p') AS Time, DATE_FORMAT(Showings.Date,'%b %D %Y') AS Date, 
			Shows.Title, Shows.Duration, Shows.Description, 
			Pictures.FileName, Pictures.Description AS altPic 
			FROM Showings
			INNER JOIN Shows ON Shows.ShowID = Showings.ShowID
			INNER JOIN ShowsPictures
			ON Shows.ShowID = ShowsPictures.ShowID
			INNER JOIN Pictures
			ON ShowsPictures.PictureID = Pictures.PictureID
			WHERE Showings.ShowingID = :sid";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':sid', $id);
    $statement->execute();
    $results = $statement->fetch();

?>
<div class=tables>
<?php
	echo "<table style='border: 1px solid black; padding: 3px;' align ='center'>";
	echo "<tr><th colspan='2'><h2>".$results["Title"]."</h2></th></tr>";
	echo "<tr><td colspan='2' align = 'center'><img src='images/".$results["FileName"]."' alt='".$results["altPic"]."' class = 'upcomingShowingPic'></td></tr>";
	echo "<tr><td>Date: ".$results["Date"]."</td><td>Show Time:".$results["Time"]."</td></tr>";
	echo "<tr><td>Length: ".$results["Duration"]." min </td><td>Remaining Seats: ".$results["SeatsAvalible"]."</tr>";
	echo "<tr><td colspan='2'>".$results["Description"]."</td></tr></table>";

?>
<h4>Reservation form</h4>
<form action="saveReserveTicket.php?id=<?php echo $id;?>&
			title=<?php echo $results["Title"];?>&
			time=<?php echo $results["Time"];?>&
			date=<?php echo $results["Date"];?>&
			dur=<?php echo $results["Duration"]; ?>" method="POST">
Enter your last name <input type=text name=lname placeholder="Last Name" required>
<br><br>
Enter your email <input type=email name=email placeholder="example@gmail.com" required autocomplete=on>
<br><br>
<?php
if($results["SeatsAvalible"] < 10)
{
?>
Number of Seats <input style="width: 100px;" type=number name=seats placeholder="(Max of <?php echo $results["SeatsAvalible"]; ?>)" min="1" max="<?php echo $results["SeatsAvalible"]; ?>" required>
<?php
}
else
{
?>
Number of Seats <input style="width: 100px;" type=number name=seats placeholder="(Max of 10)" min="1" max="10" required>
<?php	
}
?>

<br><br>
<button type="submit">Reserve Ticket</button>

</form>
<div>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>