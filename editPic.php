<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
    <link rel="stylesheet" href="lookPretty.css" />
	<title>Edit Picture</title>
</head>
<body class = "plutoBackground">
 
 <?php
 include "adminNavigation.php";
 require_once "config.php";
            
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   //get existing pic info
    $sql = "SELECT * FROM Pictures
			WHERE PictureID = :pid";
    $statement = $pdo->prepare($sql);
	$statement->bindValue(':pid', $_GET['id']);
	$statement->execute();
	$results = $statement->fetch();
	
	//get list of all shows connected to picture (may be empty set)
	$sql = "SELECT Shows.ShowID, Title
			FROM ShowsPictures
			INNER JOIN Shows
			ON ShowsPictures.ShowID = Shows.ShowID
			WHERE PictureID = :pid";
    $statement = $pdo->prepare($sql);
	$statement->bindValue(':pid', $_GET['id']);
	$statement->execute();
	
	//get list of all shows
	$sql = "SELECT ShowID, Title FROM Shows ORDER BY Title";
	$stmnt = $pdo->prepare($sql);
	$stmnt->execute();
	
    $pdo=null;

?>
<div class="forms">
<h2> Edit Picture</h2>
<br>
<img src=images/<?php echo $results["FileName"] ?> align="center" class="galleryImages">
<form action="saveEditPic.php?id=<?php echo $results["PictureID"]; ?>" method="POST">
Description:<br>
<textarea rows="5" cols="50" name="description">
<?php echo $results["Description"]; ?>
</textarea>
<br><br>
<h3>Update Connected Shows</h3>
<p><b>Add Connection</b></p>
<select name="addConnection">
<option value= "-1" selected></option>
<?php
while($row = $stmnt->fetch())
	{
		echo "<option value=".$row["ShowID"].">".$row["Title"]."</option>";
	}
?>
</select>
</br>
<p><b>Remove Connected Show</b></p>
<select name="deleteConnection">
<option value= "-1" selected></option>
<?php
$count = 0;
while($linkedShows = $statement->fetch())
{
	echo "<option value=".$linkedShows["ShowID"].">".$linkedShows["Title"]."</option>";
	$count += 1;
}
if ($count == 0)
{
	echo"<option value='-2'>No existing connected shows</option>";
}
?>
</select>
<br><br>
<button type="submit" name="upload">Save Changes</button>
</form>
<br><br>
<a href="deletePic.php?id=<?php echo $_GET["id"]."&fileName=".$results["FileName"]; ?>" class="dangerLink">Delete Picture</a>
<div>
</body>
</html>

<?php
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>

