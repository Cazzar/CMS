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

}

