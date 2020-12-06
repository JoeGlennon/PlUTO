<?php	
$mailSent = FALSE;
$errors = array();
if (isset($_POST["cancelTicket"])) 
{	
	$email = $_POST["userEmail"];
	$tixNum = $_POST["userTicketNum"];

	if(empty($email))
	{
		array_push($errors, "Email is required");
	}
	if(empty($tixNum))
	{
		array_push($errors, "Ticket Number is required");
	}
	
	if(empty($errors))
	{
		try 
		{
			require_once "config1.php";
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//verify ticket & email
			$sql = "SELECT * FROM Tickets
					INNER JOIN Users
					ON Users.UserID = Tickets.UserID
					WHERE TicketNum = :tix AND Email = :eml";
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':tix', $tixNum);
			$statement->bindParam(':eml', $email);
			$statement->execute();
			$rows = $statement->rowCount();
			$results = $statement->fetch();
			if ($rows == 1)
			{	
				//update tickets
				$sql = "UPDATE Tickets
						SET Canceled = '1'
						WHERE TicketNum = :tix";
				$statement = $pdo->prepare($sql);
				$statement->bindParam(':tix', $tixNum);
				$statement->execute();
				
				//update Seats Avalible
				$sql = "UPDATE Showings
						SET SeatsAvalible = (SeatsAvalible + :nst)
						WHERE ShowingID = :sid";
				$statement = $pdo->prepare($sql);
				$statement->bindValue(':nst', $results["NumSeats"]);
				$statement->bindValue(':sid', $results["ShowingID"]);
				$statement->execute();
				
				//send mail
				$subject = "Loras Planetarium Reservation Canceled";
				$msg = "<p>Thank You! Your Loras College Planetarium reservation has been canceled.</p>";
				$header = "From: do_not_reply@loras.edu \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";
				$mailSent = mail($email, $subject, $msg, $header);				
			}			
			
		
			$pdo=null;
		}
		catch (PDOException $e) 
		{
			die( $e->getMessage() );
		}
	}
}
?>