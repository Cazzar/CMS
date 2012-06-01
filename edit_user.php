<?php
	$Usertypes = array( 0 => "Registered", 1 => "Admin", 2 => "Editor");
	require_once('database.php');
	$users = runQuery("SELECT * FROM `users` WHERE ID='" . (String) $_SESSION['ID'] . "'");
	//$users = runQuery("SELECT * FROM `users` WHERE ID='1'");
	if ($users[0]['usertype'] != 1){echo "Editing your user";}
	else
		$users = runQuery("SELECT * FROM `users`");
	if (isset($users[1]))
	{
		echo "<form method=\"POST\" action=\"index.php?do=edituser\"><select name=\"user\">";
		$i=0;
		$userIndex = 0;
		foreach ($users as $user) {
			if ($_SESSION['username'] == $user['username']) $userIndex = $i;
			echo "\n<option value=" . $i . ">" . $user["username"] . "</option>";
			$i++; 
		}
		echo "<input type=\"submit\" value=\"Edit\" />";
		echo "\n</select></form>";
		if (!isset($_POST['user']))
		{
			echo "Editing " . $users[$userIndex]["username"] . "</br>"?>

                	<form method="POST" action="index.php?do=edituser">
                	  Username: <input type="text" name="username" size="15" value="<?php echo $users[$userIndex]['username'] ?>" /><br />
                	  Password: <input type="password" name="password" size="15" /><br />
                	  E-mail:   <input type="text" name="email" size="15" value="<?php echo $users[$userIndex]['email'] ?>" /><br />
                	  <div align="center">
                	    <p><input type="submit" value="Edit" /></p>
                	  </div>
                	</form>
		<?php
		}
	}	
	else
	{
		echo "Editing " . $users[0]["username"] . "</br>"?>

	<form method="POST" action="index.php?do=edituser">
          Username: <input type="text" name="username" size="15" value="<?php echo $users[0]['username'] ?>" /><br />
          Password: <input type="password" name="password" size="15" /><br />
	  E-mail:   <input type="text" name="email" size="15" value="<?php echo $users[0]['email'] ?>" /><br />
	  
          <div align="center">
            <p><input type="submit" value="Edit" /></p>
          </div>
        </form>

	<?php
	}
	
	if (isset($_POST['user']))
	{
		$i=$_POST['user'];
		echo "Editing " . $users[$i]["username"] . "</br>"?>

        	<form method="POST" action="index.php?do=edituser">
        	  Username: <input type="text" name="username" size="15" value="<?php echo $users[$i]['username'] ?>" /><br />
        	  Password: <input type="password" name="password" size="15" /><br />
        	  E-mail:   <input type="text" name="email" size="15" value="<?php echo $users[$i]['email'] ?>" /><br />
        	  <div align="center">
        	    <p><input type="submit" value="Edit" /></p>
        	  </div>
        	</form>
        <?php
	}
