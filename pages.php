<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

	
//	define(IN_CMS, 1);	
//	require_once("config.php");
?>
<!--<html>
	<head>
		<title><?php echo($config['cms_name']); ?> - Page List</title>
	</head>-->
	
	<body>
<?php
	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	$database = mysql_select_db($config['mysql_database'], $link);
	if (!$database) {
		die ('Can\'t use database : ' . mysql_error());
	}

	$FirstPageQuery = "SELECT * FROM `pages`";

	// Perform Query
	$result = mysql_query($FirstPageQuery);
	
	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "<br/>";
	    $message .= 'Whole query: ' . $FirstPageQuery;
	    die($message);
	}
	
	while ($row = mysql_fetch_assoc($result)) {
	    $title = $row['Title'];
	    $ID = $row['ID'];
	    $text = substr(strip_tags($row['Data'], "<b><i>"), 0, 50);

	    if (strlen($text) == 50) $text .= "...";
	    //$arr = explode(basename(__FILE__), curPageURL());
	    //if (!IsNullOrEmptyString($arr[0]))
            echo "<a href=index.php?do=view&pageid=" . $ID . ">" . $title . "</a> &nbsp - " . $text . " <br/>";
	}
