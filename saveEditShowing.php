<?php
require_once "config1.php";

try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_GET["id"];
	$cap = $_GET["ogCapacity"];
	$seats = $_GET["seatsAvalible"];
	$seatsUpdated = $seats + ($_POST["Capacity"] - $cap);
	$sql = "UPDATE Showings 
			SET Capacity = :cpt, SeatsAvalible = :avl, Time = :tme, Date = :dte
			WHERE ShowingID = :sid ";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':cpt', $_POST["Capacity"]);
	$statement->bindParam(':avl', $seatsUpdated);
    $statement->bindValue(':tme', $_POST["Time"]);
    $statement->bindValue(':dte', $_POST["Date"]);
	$statement->bindParam(':sid', $id);
    $statement->execute();  
    $pdo=null;      
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>