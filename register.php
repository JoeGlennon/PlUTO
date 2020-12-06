<!DOCTYPE html>
<?php 
include( 'checkLogin.php');
include('saveRegister.php'); ?>
<html>
<head>
  <title>PlUTO: Managment Registration</title>
<link rel="stylesheet" href="lookPretty.css" />
</head>
<body class = "plutoBackground">
<?php include('adminNavigation.php'); ?>

  <div class="tables">
  	<h1>PlUTO: Managment Registration</h1>	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
	<div class="input-group">
		<label>Account Type</label>
		<select name="permissions">
			<option value="0" selected>Check In Clerk</option>
			<option value="1">Administrator</option>
		</select>
  </div>
  	<div class="input-group">
		<input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
		<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
		<input type="password" placeholder="Password" name="password_1" 
		pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
  	</div>
  	<div class="input-group">
		<input type="password" placeholder="Confirm Password" name="password_2" 
		pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
  	</div>
  	<div class="input-group">
		<button type="submit" class="btn" name="createAcct">Create Account</button>
  	</div>
  </form>
 </div>
</body>
</html>