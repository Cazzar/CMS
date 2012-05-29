<?php
	//session_start();
	//define("IN_CMS", 1);
	//require_once("config.php");
?>
<html>
	<!--<head>
		<title><?php echo($config['cms_name']); ?> - Add new page</title>
	</head>-->
	
	<body>
	<?php
	if
 		(( !$config["admin_only_add_pages"] || ($config["admin_only_add_pages"] && $_SESSION['admin']) )
		&& !(isset($_POST['title']) && isset($_POST['page']))
	)	
	{
	?>

        <form method="POST" action="index.php?do=addpage">
	  Page Title: <input type="text" name="title" size="10" /><br />
	  Page Content: 
	  <div align="center">
	    <textarea style="width: 90%;" rows="5" wrap="hard" name="page"></textarea><br/>
	    <p><input type="submit" value="Add Page" /></p>
	  </div>
	</form>
	<?
	}
	else
	{	
		echo "You are not allowed to add pages!";
		die();
	}

	if (isset($_POST['title']) && isset($_POST['page']))
	{
		$title = $_POST['title'];
		$page = $_POST['page'];
	}
	else
	{ die(); }
	

	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	$database = mysql_select_db($config['mysql_database'], $link);
	if (!$database) {
		die ('Can\'t use database : ' . mysql_error());
	}
	$query = "INSERT INTO `pages` (`ID`, `Title` ,`Data`) VALUES (NULL, '" . mysql_real_escape_string($title) . "', '". mysql_real_escape_string(nl2br($page)) . "')";

	// Perform Query
	$result = mysql_query($query);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	    $message .= 'Whole query: ' . $FirstPageQuery;
	    die($message);
	}
	else
	{
		echo ("page added!");	
	}
