<?php

require_once "config1.php";


try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "INSERT INTO Shows(Title, Duration, Description) ";
    $sql .= "VALUES(:ttl, :dur, :des)";
	//insert Show
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':ttl', $_POST["title"]);
    $statement->bindValue(':dur', $_POST["duration"]);
    $statement->bindValue(':des', $_POST["description"]);
    $statement->execute();   
	$sid = $pdo->lastInsertId();
    
	//insert Picture
	$sql = "INSERT INTO Pictures(FileName, Description)";
    $sql .= "VALUES(:fil, :des)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':fil', $_FILES['image']['name']);
    $statement->bindValue(':des', $_POST["altText"]);
	$statement->execute();
	$pid = $pdo->lastInsertId();
	
	//establish target path for file
	$targetDir = "images/";
	$targetFile = $targetDir . basename($_FILES['image']['name']);

	//Attempt file upload
	move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

	// Code to link pic to show	
	$sql2 = "INSERT INTO ShowsPictures(PictureID, ShowID)";
	$sql2 .= "VALUES(:pid, :sid)";	
	$statement2 = $pdo->prepare($sql2);
	$statement2->bindParam(':pid', $pid);
	$statement2->bindValue(':sid', $sid);
	$statement2->execute();

    $pdo=null; 
	
	
	header("Location: http://".$_SERVER['HTTP_HOST']."/shows.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}


?>