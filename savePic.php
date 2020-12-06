<?php

require_once "config1.php";


try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "INSERT INTO Pictures(FileName, Description)";
    $sql .= "VALUES(:fil, :des)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':fil', $_FILES['image']['name']);
    $statement->bindValue(':des', $_POST["Description"]);
	$statement->execute();
	$id = $pdo->lastInsertId();
	//establish target path for file
	$targetDir = "images/";
	$targetFile = $targetDir . basename($_FILES['image']['name']);

	//Attempt file upload
	move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
	
	//if a show is selected 
if($_POST["showID"] != "-1")
{
	// Code to link pic to show	
	$sql2 = "INSERT INTO ShowsPictures(PictureID, ShowID)";
	$sql2 .= "VALUES(:pid, :sid)";	
	$statement2 = $pdo->prepare($sql2);
	$statement2->bindParam(':pid', $id);
	$statement2->bindValue(':sid', $_POST["showID"]);
	$statement2->execute();
}

    $pdo=null; 
	
    //redirects to editing page for show just entered
	header("Location: http://".$_SERVER['HTTP_HOST']."/adminGallery.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}


?>