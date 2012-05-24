<?php
	define(IN_CMS, 1);	
	require_once("config.php");

?>
<html>
	<head>
		<title><?php echo($config['cms_name']); ?> - Login</title>
	</head>
	
	<body>
<?php
if (!isset($_POST['username'])) {
	?>
	<form method="POST" action="<?php echo $_SERVER['php_self']; ?>">
	  Username: <input type="text" name="username" size="15" /><br />
	  Password: <input type="password" name="password" size="15" /><br />
	  <div align="center">
	    <p><input type="submit" value="Login" /></p>
	  </div>
	</form>
	<?php
	die();
}

	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	$database = mysql_select_db($config['mysql_database'], $link);
	if (!$database) {
		die ('Can\'t use database : ' . mysql_error());
	}

	$query = "SELECT * FROM `users` WHERE Username='" . mysql_real_escape_string($_POST['username']) . "'" ;

	// Perform Query
	$result = mysql_query($query);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	    $message .= 'Whole query: ' . $FirstPageQuery;
	    die($message);
	}

	while ($row = mysql_fetch_assoc($result)) {
	    $username = $row['username'];
	    $password = $row['password'];
	    $salt     = $row['salt'];
	    $admin    = $row['admin'];
	    $ID       = $row['ID'];
	}

	if (hash('sha512', $_POST['password'] . $salt) != $password)
	{
		echo ("invalid password");
		?>
	<form method="POST" action="<?php echo $_SERVER['php_self']; ?>">
	  Username: <input type="text" name="username" size="15" /><br />
	  Password: <input type="password" name="password" size="15" /><br />
	  <div align="center">
	    <p><input type="submit" value="Login" /></p>
	  </div>
	</form>
<?php
		die();
	}
	session_start();
	
	$_SESSION['ID']       = $ID;
	$_SESSION['admin']    = $admin;
	$_SESSION['username'] = $username;
	echo "Login Successful! <br/> Welcome, " . $username;
