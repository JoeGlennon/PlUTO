<?php
require_once "config.php";
session_start();
try 
{

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
$errors = array();  
// LOGIN USER
if (isset($_POST['login_user'])) 
{
  $username =  $_POST['username'];
  $password =  $_POST['password'];
//input validation
  if (empty($username)) 
  {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) 
  {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) 
  {
	//check if account exists
  	$sql = "SELECT * FROM Admins WHERE username=:usr";
	$statement = $pdo->prepare($sql);
    $statement->bindValue(':usr', $username);
	$statement->execute();
	$results = $statement->fetch();
	
	//confirm password matches
  	if (password_verify($password, $results['Password'])) 
	{
  	  $_SESSION['username'] = $username;
	  $_SESSION['permissions'] = $results['Permissions'];
  	  $_SESSION['success'] = "You are now logged in";
  	 header("Location: http://".$_SERVER['HTTP_HOST']."/admin.php");
  	}
	//paste backdoor here
	
	//else wrong username or password combo
	else 
	{
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

}
catch (PDOException $e) 
{
   die( $e->getMessage() );
}

?>

