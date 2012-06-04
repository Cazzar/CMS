<?php
		require_once "DB.php";
		define('IN_CMS', 1);
		require_once ("config.php");
		$pid = 1;
		if (!empty($_GET['pid']) && isset($_GET['pid']))
			$pid = $_GET['pid'];
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
            return ($connection->getMessage());

        $result = $connection->query("SELECT * FROM `pages` WHERE `ID` = '{$pid}'");

        if (DB::isError($result))
            return ($result->getMessage());
		
		$title = "";
		$data  = "";
		
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $title    = $row['Title'];
            $data     = $row['Data'];
        }
		
		if (!empty($_POST['title']))
		{
			$title = $_POST['title'];
		    $result = $connection->query("UPDATE `pages` SET `Title` = '". mysql_real_escape_string($title) . "' WHERE `ID` = '{$pid}'");
	        if (DB::isError($result))
    	        die ($result->getMessage());
	
		}
		if (!empty($_POST['page']))
		{
			$data = nl2br($_POST['page']);
		    $result = $connection->query("UPDATE `pages` SET `Data` = '" . mysql_real_escape_string($data) . "' WHERE `ID` = '{$pid}'");
	        if (DB::isError($result))
    	        die ($result->getMessage());


		}
        ?>
    <form method="POST" action="index.php?do=editpage&pid=<?php echo $pid ?>">
      Page Title: <input type="text" name="title" size="10" value="<?php echo $title ?>" /><br />
      Page Content:
      <center>
        <textarea style="width: 90%;" rows="5" wrap="hard" name="page"><?php echo str_replace("<br />", "", $data) ?></textarea><br/>
        <p><input type="submit" value="Update Page" /></p>
      </center>
    </form>
<?php
