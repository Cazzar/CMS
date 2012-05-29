<?php
	//CMS for basic website
//	define(IN_CMS, 1);	
//	require_once("config.php");
//	session_start();
	
	$index = true;
	$id = 1;
	
	if (isset($_GET['pageid'])) {
		//set for a default if the PID in URL is null.
		$id = $_GET['pageid'];
	}
		
	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
	$database = mysql_select_db($config['mysql_database'], $link);
	if (!$database) {
		die ('Can\'t use database : ' . mysql_error());
	}

	$FirstPageQuery = "SELECT * FROM `pages` WHERE ID=" . mysql_real_escape_string($id) ;

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
	    $page = $row['Data'];
	}
?>
		<title><?php echo($config['cms_name']) . " - " . $title; ?></title>
	</head>
	
	<body>
<?php
	require_once('header.php');
	echo "<p>" . $page . "</p>";
