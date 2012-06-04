<?php
	$Usertypes = array( 0 => "Registered", 1 => "Admin", 2 => "Editor");
	require "user.php";
	$users = User::getAllUsers();
	//$users = runQuery("SELECT * FROM `users` WHERE ID='1'");
	if ($users[0]->usertype != 1){echo "Editing your user";}
	else
		$users = array(new User($_SESSION['ID']));
	if (isset($users[1]))
	{
		echo "<form method=\"POST\" action=\"index.php?do=edituser\"><select name=\"user\">";
		$i=0;
		$userIndex = $_SESSION['id'];
		foreach ($users as $user) {
			if ($_SESSION['username'] == $user->username)
				$userIndex = $i;
			echo "\n<option value={$user->id}>{$user->username}</option>";
			$i++; 
		}
		echo "<input type=\"submit\" value=\"Edit\" />";
		echo "\n</select></form>";
		if (!isset($_POST['user']))
		{
			echo "Editing " . $users[$userIndex]->username . "</br>"?>
            <form method="POST" action="index.php?do=edituser">
        	  Username: <input type="text" name="username" size="15" value="<?php echo $users[$userIndex]->username ?>" /><br />
           	  Password: <input type="password" name="password" size="15" /><br />
           	  E-mail:   <input type="text" name="email" size="15" value="<?php echo $users[$userIndex]->email ?>" /><br />
           	  <input type=hidden name=userID value="<?php echo $users[$userIndex]->id ?>" />
           	  <div align="center">
           	    <p><input type="submit" value="Edit" /></p>
          	  </div>
          	</form>
		<?php
		}
	}	
	else
	{
		echo "Editing " . $users[0]->username. "</br>"?>

		<form method="POST" action="index.php?do=edituser">
          Username: <input type="text" name="username" size="15" value="<?php echo $users[0]->username ?>" /><br />
          Password: <input type="password" name="password" size="15" /><br />
		  E-mail:   <input type="text" name="email" size="15" value="<?php echo $users[0]->email ?>" /><br />  
          <div align="center">
            <p><input type="submit" value="Edit" /></p>
          </div>
        </form>

	<?php
	}
	
	if (isset($_POST['user']))
	{
		$i=new User($_POST['user']);
		echo "Editing {$users[$i]->username}</br>"?>

        	<form method="POST" action="index.php?do=edituser">
        	  Username: <input type="text" name="username" size="15" value="<?php echo $i->username ?>" /><br />
        	  Password: <input type="password" name="password" size="15" /><br />
        	  E-mail:   <input type="text" name="email" size="15" value="<?php echo $i->email ?>" /><br />
        	  <input type=hidden name=userID value="<?php echo $i->id ?>" />
        	  <div align="center">
        	    <p><input type="submit" value="Edit" /></p>
        	  </div>
        	</form>
        <?php
	}

	if (isset($_POST['username']) && !empty($_POST['username']))
	{
		if (isset($users[1]) && isset($_POST['user']))
		{
			$user = new User($_POST['user']);
			if ($user->username != $_POST['username'])
				$user->setUsername($_POST['username']);
		echo "username updated successfully<br/>";
		}
		else
		{
			if ($users[0]->username != $_POST['username'])
				$users[0]->setUsername($_POST['username']);
		echo "username updated successfully<br/>";
		}
	}
	if (isset($_POST['password']) && !empty($_POST['password']))
	{
        if (isset($users[1]) && isset($_POST['user']))
        {
        	$user = new User($_POST['user']);
        	$user->setPassword($_POST['password']);
		echo "password updated successfully<br/>";
        }
        else
        {
        	$users[0]->setPassword($_POST['password']);
		echo "password updated successfully<br/>";
        }
	}
	if (isset($_POST['email']) && !empty($_POST['email']))
	{
        if (isset($users[1]) && isset($_POST['user']))
        {
        	$user = new User($_POST['user']);
		if ($user->email != $_POST['email'])
			$user->setEmail($_POST['email']);
		echo "email updated successfully<br/>";
        }
        else
        {
		if ($users[0]->email != $_POST['email'])
			$users[0]->setEmail($_POST['email']);
		echo "email updated successfully<br/>";
        }
	}
