
<?php 
if (isset($_SESSION['permissions']))
{
	if($_SESSION['permissions'] == 1){ ?>
	<table align=Center class=navigation>
	<tr>
	<th colspan="7"><h1>PlUTO: Managment</h1></th>
	</tr>
	<tr>
	<td colspan="7" class=navigation><?php  if (isset($_SESSION['username'])){echo"Howdy <strong>".$_SESSION['username']."</strong>";} ?></td>
	</tr>
	<tr class=navigation>
	<td class=navigation><a class=navLink href="admin.php">Home</a></td>
	<td class=navigation><a class=navLink href="adminGallery.php">Gallery</a></td>
	<td class=navigation><a class=navLink href="shows.php">Shows</a></td>
	<td class=navigation><a class=navLink href="reports.php">Reports</a></td>
	<td class=navigation><a class=navLink href="checkIn.php">Check In</a></td>
	<td class=navigation><a class=navLink href="register.php">Create Account</a></td>
	<td class=navigation><a class=navLink href="admin.php?logout='1'" style="color: red;">Logout</a></td>
	</tr>
	</table>
	<?php } 
	else if($_SESSION['permissions'] == 0) { ?>
	<table align=Center class=navigation>
	<tr>
	<th colspan="5"><h1>PlUTO: Check In</h1></th>
	</tr>
	<tr>
	<td colspan="5" class=navigation><?php  if (isset($_SESSION['username'])){echo"Howdy <strong>".$_SESSION['username']."</strong>";} ?></td>
	</tr>
	<tr class=navigation>
	<td class=navigation><a class=navLink href="index.php">Home</a></td>
	<td class=navigation><a class=navLink href="gallery.php">Gallery</a></td>
	<td class=navigation><a class=navLink href="aboutUs.php">About Us</a></td>
	<td class=navigation><a class=navLink href="checkIn.php">Check In</a></td>
	<td class=navigation><a class=navLink href="admin.php?logout='1'" style="color: red;">Logout</a></td>
	</tr>
	</table>	
	
	<?php  }
}
else
{ ?>
<table align=Center class=navigation>
<tr><th colspan="3"><h1>PlUTO: Planetarium User Ticketing Online</h1></th></tr>
<tr>
<td class=navigation><a class=navLink href="index.php">Home</a></td>
<td class=navigation><a class=navLink href="gallery.php">Gallery</a></td>
<td class=navigation><a class=navLink href="aboutUs.php">About Us</a></td>
</tr>
</table>

<?php
}
?>