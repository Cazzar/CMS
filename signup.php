<html>
<head>
	<title><?php echo($config['cms_name']); ?> - Sign Up</title>
</head>
<body>
<?php
	session_start();
	define(IN_CMS, 1);
	require_once("config.php");
	if (
		(!$config["admin_only_add_users"]
			 || ($config["admin_only_add_users"] && $_SESSION['admin'])
		)
		&& !(isset($_POST['email']) 
		     && isset($_POST['password_confirm'])
		     && isset($_POST['password']) 
		     && isset($_POST['username'])
		)
	)
	{
?>
        <form method="POST" action="<?php echo $_SERVER['php_self']; ?>">
	  Username: <input type="text" name="username" size="15" /><br />
	  Password: <input type="password" name="password" size="15" /><br />
	  Again: <input type="password" name="password_confirm" size="15" /><br />
	  E-Mail: <input type="text" name="email" size="15" /><br />
	<div align="center">
	    <p><input type="submit" value="Login" /></p>
	  </div>
	</form>
	<?php 
die(); 
} 

	if ($config["admin_only_add_users"] && !($config["admin_only_add_users"] && $_SESSION['admin'] = "1") ) 
	{ die("You are not allowed to add users"); }

	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	$database = mysql_select_db($config['mysql_database'], $link);
	
	if (!$database) {
		die ('Error logging in cannot use database : ' . mysql_error());
	}
	
	$salt = rand_string(5);
	$hashed_pw = hash('sha512', $_POST['password'] . $salt);

	if (!mysql_query("INSERT INTO `users` (`ID`, `username`, `email`, `password`, `salt`, `admin`) VALUES
(NULL, '" . $_POST['username'] . "', '" . $_POST['email'] . "', '" . $hashed_pw . "', '" . $salt . "', " . "0" . ")"))
	{
		die("Error inserting user, maybe a duplicate username or email?");
	}                                                                                                                                                                                                                                                                                                                                                                                 
	

	$query = "SELECT * FROM `users` WHERE Username='" . mysql_real_escape_string($_POST['username']) . "'" ;

	// Perform Query
	$result = mysql_query($query);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	    $message .= 'Whole query: '   . $FirstPageQuery;
	    die($message);
	}

	while ($row = mysql_fetch_assoc($result)) {
	    $username = $row['username'];
	    $password = $row['password'];
	    $salt     = $row['salt'];
	    $admin    = $row['admin'];
	    $ID       = $row['ID'];
	}

	session_start();
	
	$_SESSION['ID']       = $ID;
	$_SESSION['admin']    = $admin;
	$_SESSION['username'] = $username;
	echo "Signup Successful! <br/> Welcome, " . $username;
	
	function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}
?>
</body>
</html>
