<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<link rel="stylesheet" href="lookPretty.css" />
<title>Edit Show</title>
</head>
<body class = "plutoBackground">
 <?php
 include "adminNavigation.php";
 require_once "config.php";
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET["id"];
    $sql = "SELECT ShowID, Title, Duration, Description FROM Shows WHERE ShowID = :sid";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':sid', $id);
	$statement->execute();
    $results = $statement->fetch();
?> 
<div class = "tables">
<h3>Edit <?php echo $results["Title"]; ?> Show</h3>
<form action="saveEditShow.php?id=<?php echo $results["ShowID"]; ?>" method="POST">
Title:<input type=text name=title value="<?php echo $results["Title"]; ?>">
<br><br>
Duration:<input type=number name=duration value="<?php echo $results["Duration"]; ?>">
<br><br>
Description:<br>
<textarea rows="5" cols="50" name=description>
<?php echo $results["Description"]; ?>
</textarea>
<br><br>
<button type="submit">Save Changes</button> <input type=reset>
</form>
<br><br>
<a href="deleteShowWarn.php?id=<?php echo $id."&title=".$results["Title"]; ?>" class="dangerLink">Delete Show</a>
<div>
</body>
</html>
<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>