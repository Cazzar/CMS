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
	mysql_query("CREATE TABLE IF NOT EXISTS `pages` ( `ID` int NOT NULL PRIMARY KEY AUTO_INCREMENT, `Title` VARCHAR(50) NOT NULL, `Data` text NOT NULL )");
	mysql_query("CREATE TABLE IF NOT EXISTS `users` ( 
 `ID` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `username` VARCHAR(20) NOT NULL,
 `email` VARCHAR(40) NOT NULL,
 `password` VARCHAR(255) NOT NULL,
 `salt` VARCHAR(10) NOT NULL,
 `admin` boolean NOT NULL
 )");
	mysql_query("ALTER TABLE `users` ADD UNIQUE (`username`,`email`)");


	//username: admin, password: password
	mysql_query("INSERT INTO `users` (`ID`, `username`, `email`, `password`, `salt`, `admin`) VALUES
(1, 'admin', 'admin@example.com', 'fd6ca1e3d777e86678e8c8a7d9a2eea2de51756284a8ddd0352b102e004dcc367fcf469610e20c380bef61332841da60d9a20be994d697aff4fa4f181c4cfe7f', 'GgaFG', 1)");
	echo  "User \"Admin\" has been added with the Password: \"password\"";

	mysql_query("INSERT INTO `pages` (`ID`, `Title` ,`Data`) VALUES ('1', 'First Page!', 'Hello and Welcome to your first page in Cayde Dixon''s CMS!')");
	//$FirstPageQuery = ""

	// Perform Query
	//$result = mysql_query($FirstPageQuery);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	//if (!$result) {
	//    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	//    $message .= 'Whole query: ' . $FirstPageQuery;
	//    die($message);
	//}
	
	// Use result
	// Attempting to print $result won't allow access to information in the resource
	// One of the mysql result functions must be used
	// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
	while ($row = mysql_fetch_assoc($result)) {
	    echo $row['ID'];
	}
