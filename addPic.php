
<div align='center' class="tables">
<h3>Add Picture</h3>

  <form method="POST" action="savePic.php" enctype="multipart/form-data">
  
	<?php

   
    $sql = "SELECT ShowID, Title FROM Shows ORDER BY Title";
	$stmnt = $pdo->prepare($sql);
	$stmnt->execute();
    $pdo=null;
?>
<div align="left">
Select a show:<br>
<select name="showID">
</div>
<option value="-1" selected> </option>
<?php 
while($row = $stmnt->fetch())
	{
		echo "<option value=".$row["ShowID"].">".$row["Title"]."</option>";
	}
?>
</select>
<br>
<div align="left">
Select a file:<br>
<input type="file" name="image" required>
</div>
<br>
  	<div>
      <textarea cols="30" rows="4" name="Description" placeholder="Say something about this image..." spellcheck="on" required></textarea>
  	</div>
	</br>
  	<div align="center">
  		<button type="submit" name="upload">Upload</button>
  	</div>
  </form>
</div>

