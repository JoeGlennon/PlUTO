<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>Add Showing</title>
</head>
<body class = "plutoBackground">
 <?php
 include "adminNavigation.php";
 require_once "config.php";  
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_GET["id"];
    $sql = "SELECT * FROM Shows WHERE ShowID = :sid";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':sid', $id);
	$statement->execute();
    $results = $statement->fetch();

?>
<div class = "tables">
<h3>Create a <?php echo $results["Title"]; ?> Showing</h3>
<form action= "saveShowing.php?id= <?php echo $results["ShowID"]; ?> " method="POST">
<p>Title: <?php echo $results["Title"]; ?></p>
<p>Duration: <?php echo $results["Duration"]; ?></p>
<p>Description: <?php echo $results["Description"]; ?></p>
<br>
Desired Capacity:<input type=number name="Capacity" min="1" max="100" required>
<br><br>
Date:<input type=date name="Date" required>
<br><br>
Time:<input type=time name="Time" required>
<br><br>
<button type="submit">Create Showing</button> <input type=reset>
</form>
</div>
</body>
</html>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>