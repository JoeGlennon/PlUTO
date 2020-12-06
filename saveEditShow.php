<?php
require_once "config1.php";
try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_GET["id"];
	$sql = "UPDATE Shows
			SET Title = :ttl, Duration = :dur, Description = :des
			WHERE ShowID = :sid";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':ttl', $_POST["title"]);
    $statement->bindValue(':dur', $_POST["duration"]);
    $statement->bindValue(':des', $_POST["description"]);
	$statement->bindParam(':sid', $id);
    $statement->execute();
 
    $pdo=null;   
    
	header("Location: http://".$_SERVER['HTTP_HOST']."/shows.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}


?>