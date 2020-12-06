<?php

require_once "config1.php";


try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "UPDATE Pictures
			SET Description = :des
			WHERE PictureID = :pid";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':des', $_POST["description"]);
	$statement->bindValue(':pid', $_GET["id"]);
    $statement->execute();
     
	 //check if show added
    if($_POST["addConnection"] != -1)
	{
		$sql = "INSERT INTO ShowsPictures
				VALUES(:pid, :sid)";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':sid', $_POST["addConnection"]);
		$statement->bindValue(':pid', $_GET["id"]);
		$statement->execute();			
	}
	//check if show is removed
	if($_POST["deleteConnection"] != -1 && $_POST["deleteConnection"] != -2 )
	{
		$sql = "DELETE FROM ShowsPictures
				WHERE PictureID = :pid AND ShowID = :sid";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':sid', $_POST["deleteConnection"]);
		$statement->bindValue(':pid', $_GET["id"]);
		$statement->execute();	
	}
	
	
	$pdo=null;

	header("Location: http://".$_SERVER['HTTP_HOST']."/adminGallery.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}


?>