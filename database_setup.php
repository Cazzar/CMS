<?php
	define('IN_CMS', 1);
	require("config.php");
	echo("Setting up database<br/>");
	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	
	echo("creating database if it doesnt exist<br/>");
	mysql_query("CREATE DATABASE IF NOT EXISTS `".mysql_real_escape_string($config['mysql_database']) ."`", $link);
	

	$database = mysql_select_db($config['mysql_database'], $link);
	
	if (!$database) {
		die ('Can\'t use database : ' . mysql_error());
	}	

	echo("Creating tables database...<br/>");
	mysql_query("CREATE TABLE IF NOT EXISTS `pages` ( `ID` int NOT NULL PRIMARY KEY AUTO_INCREMENT, `Title` text NOT NULL, `Data` text NOT NULL )");
	
	$FirstPageQuery = "INSERT INTO `pages` (`ID`, `Title` ,`Data`) VALUES ('', 'First Page!', 'Hello and Welcome to your first page in Cayde Dixon''s CMS!')";

	// Perform Query
	$result = mysql_query($FirstPageQuery);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	    $message .= 'Whole query: ' . $FirstPageQuery;
	    die($message);
	}
	
	// Use result
	// Attempting to print $result won't allow access to information in the resource
	// One of the mysql result functions must be used
	// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
	while ($row = mysql_fetch_assoc($result)) {
	    echo $row['ID'];
	}
