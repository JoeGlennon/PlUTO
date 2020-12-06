<!DOCTYPE html>
<html>
<head>
</head>
<body>
 
<?php
include "barcode.php";
require_once "config1.php";
	try 
	{
	//create the ticket and user 
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CALL reserveTicket(:eml, :nme, :num, :sid)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':eml', $_POST["email"]);
	$statement->bindValue(':nme', $_POST["lname"]);
	$statement->bindValue(':sid', $_GET["id"]);
	$statement->bindValue(':num', $_POST["seats"]);
	$statement->execute();
	
	$sql = "SELECT TicketNum FROM Tickets
			INNER JOIN Users
			ON Users.UserID = Tickets.UserID
			WHERE Users.Email = :eml AND Tickets.ShowingID = :sid
			ORDER BY TicketID DESC
			LIMIT 1";
			
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':eml', $_POST["email"]);
	$statement->bindValue(':sid', $_GET["id"]);
	$statement->execute();
	$results = $statement->fetch(); 
	$ticketNum = $results["TicketNum"];
	//generate barcode
	$filepath = "/var/www/html/images/barcodes/".$ticketNum.".png";
	barcode($filepath, $results["TicketNum"], 30, "horizontal", "code128", true);
	
	//email ticket to user
	$imgSrc="http://pluto.loras.edu/images/barcodes/".$ticketNum.".png";
	$to = $_POST["email"];
	$subject = "Planetarium Reservations";
	$header = "From: do_not_reply@loras.edu \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
	$message = "<html>
		<head>
		<title>Planetarium Reservations</title>
		<style> th, td {text-align: center;} </style>
		</head>
		<body>
		<h1>Reservation Successful</h1>
		<p>Thank you for reserving your seats. Here is your admission ticket</p>
		<div class = 'ticket' align = 'left'>
		<table style='border: 2px solid black'>
		<tr>
		<th colspan='2'>";
		$message .= $_GET["title"];
		$message .= "</th></tr><tr><td>Date:</td><td>Show Time:</tr>";
		$message .= "<tr><td>".$_GET['date']."</td><td>".$_GET["time"]."</td></tr>";
		$message .= "<tr><td>Duration:</td><td>Seats Reserved:</td></tr>";
		$message .= "<tr><td>".$_GET["dur"]."</td><td>".$_POST["seats"]."</td></tr>";
		$message .= "<tr><td colspan='2'>
		<img src='".$imgSrc."' alt='".$ticketNum."' height='75' width='160'></td></tr>
		</table>
		</div>
		<p>Reservations do not guarentee your seats.</p>
		<p>Please show up 10 minutes prior</p>
		</body>
		</html>	";
	$mailSent = mail($to, $subject, $message, $header);
	if($mailSent)
	{
		//mail was sent
	}
	else
	{
		//ticket failed to send	
	}
	/*
    //open printable ticket in newe tab
	?>
	<script language="javascript">
	function openTicket(title, date, time, duration seats, tixNum){
		window.open("http://pluto.loras.edu/printableTicket?title="+title+"&date="+date+"&time="+time+"&dur="+duration+"&seat="+seats+"&ticket="+tixNum)
	}
	
	openTicket(<?php echo $_GET["title"]?>, <?php echo $_GET["date"]?>, <?php echo $_GET["time"]?>, <?php echo $_GET["dur"]?>, <?php echo $_POST["seats"]?>, <?php echo $results["TicketNum"]?> );
		
	</script>
	<?php
		*/
	//check capacity
	$sql = "SELECT SeatsAvalible
			FROM Showings
			WHERE ShowingID = :sid";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':sid', $_GET["id"]);
	$statement->execute();
	$results = $statement->fetch(); 
	//if less than 10 tickets left, update index to say so
	if($results["SeatsAvalible"] < 10)
	{
		if($results["SeatsAvalible"] < 5)
		{
			mail("heitkamp.planetarium@gmail.com", "Capacity Alert", "5 seats left. Consider updating the shows capacity or creating an additional showing.", $header);
				if($results["SeatsAvalible"] < 1)
				{
					//send alert to heitkamp.planetarium@gmail.com
					mail("heitkamp.planetarium@gmail.com", "Capacity Alert", "Max Capacity Reached", $header);
				}
		}
	}

	header("Location: http://".$_SERVER['HTTP_HOST']."/printableTicket.php?title=". $_GET["title"]."&date=". $_GET["date"]."&time=".$_GET["time"]."&dur=".$_GET["dur"]."&seat=".$_POST["seats"]."&ticket=".$ticketNum);
	//header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
	
	
	$pdo=null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
}

?>

</body>
</html>
