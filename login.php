<?php
//	define(IN_CMS, 1);	
//	require_once("config.php");

?>
<!--<html>
	<head>
		<title><?php echo($config['cms_name']); ?> - Login</title>
	</head>-->
	
	<body>
<?php
require "user.php";
if (!isset($_POST['username'])) {
	?>
	<form method="POST" action="index.php?do=login">
	  Username: <input type="text" name="username" size="15" /><br />
	  Password: <input type="password" name="password" size="15" /><br />
	  <div align="center">
	    <p><input type="submit" value="Login" /></p>
	  </div>
	</form>
	<?php
	die();
}
	$user = User::findUsersByName($_POST['username']);
	
	if (is_string($user))
	{
		echo ("invalid user");
    ?>
        <form method="POST" action="index.php?do=login">
          Username: <input type="text" name="username" size="15" /><br />
          Password: <input type="password" name="password" size="15" /><br />
          <div align="center">
            <p><input type="submit" value="Login" /></p>
          </div>
        </form>
	<?
		die();
	}
	
	if (!$user->checkPassword($_POST['password']))
	{
		echo ("invalid password");
	?>
	<form method="POST" action="index.php?do=login">
	  Username: <input type="text" name="username" size="15" /><br />
	  Password: <input type="password" name="password" size="15" /><br />
	  <div align="center">
	    <p><input type="submit" value="Login" /></p>
	  </div>
	</form>
<?php
		die();
	}
	header("Refresh: 3; url=\"index.php\"");
	//session_start();
        	
	$_SESSION['ID']       = (int) $user->id;
	$_SESSION['usertype'] = (int) $user->usertype;
	$_SESSION['username'] = $user->username;
	echo "Login Successful! <br/> Welcome, " . $_SESSION['username'] . "<br/>";
 echo "You will be redirected to in 3 seconds...";
