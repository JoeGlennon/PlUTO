<!DOCTYPE html>
<?php include "checkLogin.php"; ?>
<html>
<head>
<title>Add Show</title>
<link rel="stylesheet" href="lookPretty.css" />
</head>
<body class = "plutoBackground">
 <?php
 include "adminNavigation.php";
 ?>
<div class="forms">
<h3>Add Show</h3>
<form action="saveShow.php" method="POST" enctype="multipart/form-data">
Show Title: <input type=text name=title placeholder="Enter a Title" spellcheck=on required>
<br><br>
Duration: <input type=number name=duration placeholder="min" min="1" max="300" required>
<br><br>
<textarea rows="5" cols="50" name = "description" placeholder="Enter the shows description..." spellcheck="on" required>
</textarea>
<br><br>
Upload a Picture: <input type="file" name="image">
<br><br>
<textarea cols="40" rows="4" name="altText" placeholder="Say something about this image..." spellcheck="on" required>
</textarea>
<br><br>
<button type="submit" name="upload">Create Show</button> <input type=reset>

</form>
</div>
</body>
</html>
