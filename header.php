<?php
//define(IN_CMS, 1);
//require_once("config.php");
if (isset($_SESSION['username'])) { 
	echo "<B>Hello, " . $_SESSION['username'] . "</b><br/>"; 
}
else {
	echo "<b>Hello guest,</b> Please <a href=\"index.php?do=login\" alt=\"login\">login</a>";
	if (!$config['admin_only_add_users']) {
		echo "or <a href=\"index.php?do=signup\" alt=\"Signup\">Signup</a><br/>";
	 }
	else echo "<br/>";
}
echo "Links: <br/><ul id=\"nav\">";
if ($actionKey != 0) 
	echo "<li><a href=\"index.php\" alt=\"Main page\"><center>Main page</center></a></li>";

echo "<li><a href=\"index.php?do=pages\" alt=\"page list\"><center>Page List</center></a></li>";
if (!$config['admin_only_add_pages']){
	echo "<li><a href=\"index.php?do=addpage\" alt=\"Add a page\"><center>Add New Page</center></a></li>";
}
else if (isset($_SESSION['usertype'])) {
	if ($_SESSION['usertype'] = 1 && $config['admin_only_add_pages']) {
	echo "<li><a href=\"index.php?do=addpage\" alt=\"Add a page\"><center>Add New Page</center></a></li>";
	}
}
if (!$config['admin_only_add_users'])
{
	echo "<li><a href=\"index.php?do=signup\" alt=\"Add a user\"><center>Add User/signup</center></a></li>";
}
else if (isset($_SESSION['usertype'])) {
        if ($_SESSION['usertype'] = 1 && $config['admin_only_add_users']) {
        echo "<li><a href=\"index.php?do=signup\" alt=\"Add a page\"><center>Add new user</center></a></li>";
        }
}


if (isset($_SESSION['username'])) {
	echo "<li><a href=\"?do=edituser\" alt=\"Edit user\"><center>Edit User</center></a></li>";
        echo "<li><a href=\"index.php?do=logout\" alt=\"Logout\"><center>Logout</center></a></li>";
}
echo "</ul><br/><br/>";
