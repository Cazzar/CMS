<?php
define(IN_CMS, 1);
require_once("config.php");
require      "user.php";
session_start();
$ActionTitles = array('', 'Page List', 'Add new page', 'Login', 'Signup', 'Logout', 'Edit User', 'test', 'Edit Page');
$ValidActions = array('view', 'pages', 'addpage', 'login', 'signup', 'logout', 'edituser', 'test', 'editpage');
$ActionPages  = array('viewpage.php', 'pages.php', 'addpage.php', 'login.php', 'signup.php',
					  'logout.php', 'edit_user.php', 'test.php', 'edit_page.php');
#if The value is set and it is in the valid actions array otherwise default
$action = (isset($_GET['do'])) ? (in_array($_GET['do'], $ValidActions)) ? $_GET['do'] : $ValidActions[0] : $ValidActions[0];
$actionKey = array_search($action, $ValidActions);
echo "<html>";
echo "\t<head>\n\t\t<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\" />";
if ($actionKey != 0)
{
?>
        	<title><?php echo $config['cms_name'] . " - " . $ActionTitles[$actionKey] ?></title>
	</head>
<?php
}

require_once('header.php');


require_once($ActionPages[$actionKey]);
//echo $action . " " . $actionKey . " " . $ActionPages[$actionKey];
