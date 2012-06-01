<?php

function runQuery($query) {
	define(IN_CMS, 1);
	require('config.php');
	$link = mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password']);
        $database = mysql_select_db($config['mysql_database'], $link);
        if (!$database) {
                die ('Can\'t use database : ' . mysql_error());
        }
        // Perform Query
        $result = mysql_query($query);

        // Check result
        // This shows the actual query sent to MySQL, and the error. Useful for debugging.
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "<br/>";
            $message .= 'Whole query: ' . $FirstPageQuery;
            die($message);
        }

        $users = array();
        while ($row = mysql_fetch_assoc($result)) {
                array_push($users, $row);
        }
	
	return $users;
}
