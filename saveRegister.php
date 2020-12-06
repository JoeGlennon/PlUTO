<?php

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// IF form submitted THEN register user
if (isset($_POST['createAcct'])) 
{
  // receive all input values from the form
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];
  $permissions = $_POST['permissions'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) 
	{ array_push($errors, "Username is required"); }
  if (empty($email)) 
	{ array_push($errors, "Email is required"); }
  if (empty($password_1)) 
	{ array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) 
    { array_push($errors, "The two passwords do not match"); }

try{
	// connect to the database
	require_once "config1.php";
	$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
  // check the database for if users info pre-exists
	$sql = "SELECT UserName, Email 
			FROM Admins
			WHERE UserName = :usr OR Email = :eml";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':usr', $username);
    $statement->bindParam(':eml', $email);
	$statement->execute();
	$results = $statement->rowCount();
	if ( $results > 0) 
	{
		while($row = $statement->fetch())
		{
		if ($row['UserName'] === $username) 
			{ array_push($errors, "Username already exists"); }
		if ($row['Email'] === $email) 
			{ array_push($errors, "Email already exists"); }
		}
	}

  // register user if no errors in the form
  if (empty($errors))
  {
	//encrypt the password before saving in the database
	$hashPass = password_hash($password_1, PASSWORD_DEFAULT);

  	$sql = "INSERT INTO Admins (Username, Email, Password, Permissions) 
  			  VALUES(:usr, :eml, :pwd, :per)";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':usr', $username);
    $statement->bindParam(':eml', $email);
	$statement->bindParam(':pwd', $hashPass);
	$statement->bindParam(':per', $permissions);
	$statement->execute();
	
	$pod=null;
	
  	$_SESSION['username'] = $username;
	$_SESSION['permissions'] = $permissions;
  	$_SESSION['success'] = "You are now logged in";
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
  }
  
}
catch (PDOException $e) 
	{
		die( $e->getMessage() );
	}
  
}
