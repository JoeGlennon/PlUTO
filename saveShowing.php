<?php
include "barcode.php";
require_once "config1.php";


try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//create showing
    $sql = "INSERT INTO Showings(ShowID, Capacity, SeatsAvalible, Time, Date)";
    $sql .= "VALUES(:sid, :cap, :avl, :tim, :dat)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':sid', $_GET["id"]);
    $statement->bindValue(':cap', $_POST["Capacity"]);
	$statement->bindValue(':avl', $_POST["Capacity"]);
    $statement->bindValue(':tim', $_POST["Time"]);
  	$statement->bindValue(':dat', $_POST["Date"]);
    $statement->execute();
	
	//get info to create blank ticket
	$id = $pdo->lastInsertId();
	
	//create blank ticket for non-reservation guest tracking
	$sql = "CALL reserveTicket('heitkamp.planetarium@gmail.com', 'BlankUser', 0, :sid)";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':sid', $id);
	$statement->execute();
   
   //get ticket number
   $sql = "SELECT TicketNum FROM Tickets
			INNER JOIN Users
			ON Users.UserID = Tickets.UserID
			WHERE Users.Email = :eml AND Tickets.ShowingID = :sid";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':eml', "heitkamp.planetarium@gmail.com");
	$statement->bindValue(':sid', $id);
	$statement->execute();
	$results = $statement->fetch(); 
	
	//generate barcode
	$filepath = "/var/www/html/images/barcodes/".$results["TicketNum"].".png";
	barcode($filepath, $results["TicketNum"], 30, "horizontal", "code128", true);
   
   
   
    $pdo=null;   
    
    //redirects to admin home page
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
}
catch (PDOException $e) {
   die( $e->getMessage() );
}

?>