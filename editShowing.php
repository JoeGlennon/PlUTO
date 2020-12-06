<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>Edit Showing</title>
</head>
<body class = "plutoBackground">
 <?php
 include "adminNavigation.php";
 require_once "config.php";  
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_GET["id"];
    $sql = "SELECT Showings.ShowingID, Showings.Capacity, Showings.SeatsAvalible, Showings.Time, Showings.Date, Shows.Title, Shows.Duration, Shows.Description FROM Showings
	INNER JOIN Shows ON Shows.ShowID = Showings.ShowID
	WHERE Showings.ShowingID = :sid";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':sid', $id);
	$statement->execute();
    $results = $statement->fetch();

?>
<div class="forms">
<h3>Edit <?php echo $results["Title"]; ?> Showing</h3>
<form action= "saveEditShowing.php?id=<?php echo $results["ShowingID"]; ?>&seatsAvalible=<?php echo $results["SeatsAvalible"]; ?>&ogCapacity=<?php echo $results["Capacity"];?>" method="POST">
<p>Title: <?php echo $results["Title"]; ?></p>
<p>Duration: <?php echo $results["Duration"]; ?></p>
<p>Description: <?php echo $results["Description"]; ?></p>
<br>
Desired Capacity:<input type=number name="Capacity" min="1" max="100" value="<?php echo $results["Capacity"]; ?>">
<br><br>
Date:<input type=date name="Date" value="<?php echo $results["Date"]; ?>">
<br><br>
Time:<input type=time name="Time" value="<?php echo $results["Time"]; ?>">
<br><br>
<button type="submit">Save Changes</button> <input type=reset>
</form>
<br><br>
<a href="http://pluto.loras.edu/deleteShowing.php?id=<?php echo $id;?>&title=<?php echo $results["Title"];?>&date=<?php echo $results["Date"];?>&time=<?php echo $results["Time"];?>" class="dangerLink">Cancel Showing</a>
</div>
</body>
</html>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>