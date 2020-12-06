
<?php
include "checkLogin.php";
require_once "config1.php";

try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	//delete show which will cascade delete all connected data
	$sql = "DELETE FROM Shows
			WHERE ShowID = :sid";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
    $statement->execute();
	
	$pdo=null;
	
	//nav back to admin home page
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
	
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>