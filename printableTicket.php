<html>
		<head>
		<title>Planetarium Reservations</title>
		<link rel="stylesheet" href="lookPretty.css" />
		<style> th, td {text-align: center;} </style>
		<script language="javascript" type="text/javascript">
        function printDiv() {
            //Get the HTML of div
            var divElements = document.getElementById("ticket").innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;          
        }
    </script>
		</head>
		<body>
		<?php  include "adminNavigation.php"; ?>
		<h1>Reservation Successful</h1>
		<p>Thank you for reserving your seats. <br> 
		Here is your admission ticket</p>
		<div id = 'ticket'>
		<table style='border: 2px solid black'>
		<tr>
		<th colspan='2'><?php echo $_GET["title"]; ?><th>
		</tr>
		<tr>
		<td>Date: </td><td>Show Time: </td>
		</tr>
		<tr>
		<td><?php echo $_GET["date"]; ?></td><td><?php echo $_GET["time"]; ?></td>
		</tr>
		<tr>
		<td>Duration: </td><td> Seats Reserved: </td>
		</tr>
		<tr>
		<td><?php echo $_GET["dur"]; ?> min</td><td><?php echo $_GET["seat"]; ?></td>
		</tr>
		<tr>
		<td colspan="2">Ticket Number</td>
		</tr>
		<tr>
		<td colspan="2"><img src="images/barcodes/<?php echo $_GET["ticket"]; ?>.png" alt="<?php echo $_GET["ticket"]; ?>" height='75' width='160'> </td>
		</tr>
		</table>
		</div>
		<p>Reservations do not guarentee your seats. 
		<br> 
		Please show up 10 minutes prior</p>
		<button onclick="printDiv()">Print Admission Ticket</button> 
		</body>
	</html>

