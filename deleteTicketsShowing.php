<!DOCTYPE html>
<html>
<head>
<?php
include "checkLogin.php";
require_once "config1.php";

try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//get list of users to email
	$sql = "SELECT Email
			FROM Users
			INNER JOIN Tickets
			ON Users.UserID = Tickets.UserID
			WHERE Tickets.ShowingID = :sid AND Tickets.Canceled = 0";
    $statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
    $statement->execute();
	$resultsForEmail = $statement->fetchAll();

	//delete all tickets for the showing
	$sql = "DELETE FROM Tickets
			WHERE ShowingID = :sid";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
    $statement->execute();
	
	//delete showing
	$sql = "DELETE FROM Showings
			WHERE ShowingID = :sid";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
    $statement->execute();


	//send each user a notification email
	foreach($resultsForEmail as $row)
	{
		//send mail
				$email = $row["Email"];
				$subject = "Loras Planetarium Showing Canceled";
				$msg = $_POST["message"];
				$header = "From: do_not_reply@loras.edu \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";
				mail($email, $subject, $msg, $header);
	}			 	
	
	$pdo=null;
	
	//nav back to admin home page
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
	
}
catch (PDOException $e) {
   die( $e->getMessage() );
}
?>

</body>
</html>