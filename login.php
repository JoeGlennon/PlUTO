<?php include('authenticate.php') ?>
<!DOCTYPE html>
<html>
<head class = "plutoBackground">
  <title>PlUTO: Managment Login</title>
  <link rel="stylesheet" href="lookPretty.css" />
</head>
<body class = "plutoBackground">
<?php include 'adminNavigation.php' ?>

  <div class="tables">
  	<h2>PlUTO: Managment Login</h2>
    	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
   <br>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
   <br>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
   </div>
  </form>
</body>
</html>