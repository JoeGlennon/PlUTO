<?php
include "checkLogin.php";
require_once "config1.php";
try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		//delete showsPicture links
		$sql = "DELETE FROM ShowsPictures
				WHERE PictureID = :pid";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':pid', $_GET["id"]);
		$statement->execute();
		
		//delete picture
		$sql = "DELETE FROM Pictures
				WHERE PictureID = :pid";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':pid', $_GET["id"]);
		$statement->execute();
		$file="images/";
		$file .= $_GET["fileName"];
		//remove file from server
		unlink($file);
		
		//nav back to admin home page
		header("Location: http://".$_SERVER['HTTP_HOST']."/adminGallery.php");		
	
	$pdo=null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>
