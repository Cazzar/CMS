<?php 
require_once "DB.php";

define("IN_CMS", 1);
#require_once "config.php";

class User
{
	var $id;
	var $username;
	var $usertype;
	var $email;
	
	//initaliser for the variable
	function __construct($id)
	{
		$this->id = $id;
		$this->loadData();
	}
	function loadData()
	{
		require "config.php";
		$dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
		$connection = DB::connect($dsn);
		
		if (DB::isError($connection))
			return ($connection->getMessage());

		$result = $connection->query("SELECT * FROM `users` WHERE ID='" . $this->id . "'");
		
        if (DB::isError($result))
        	return ($result->getMessage());

		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$this->username = $row['username'];
			$this->usertype = $row['usertype'];
			$this->email    = $row['email'];
			/*foreach ($row as $key => $value)
			{
				
			}
			print "\n";*/
		}
	}
	
	function setPassword($password)
	{
		require "config.php";
		$salt = $this->rand_string(5);
	    $hashed_pw = hash('sha512', $password . $salt);
		
		$query = "UPDATE `users` SET `password` = '{$hashed_pw}', `salt` = '{$salt}' WHERE `ID` = {$this->id}";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
        	return ($connection->getMessage());
		
        $result = $connection->query($query);
        if (DB::isError($result))
             return ($result->getMessage());
	}
	
	function setUsername($username)
    {
        require "config.php";

        $query = "UPDATE `users` SET `username` = '{$username}' WHERE `ID` = {$this->id}";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
            return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
            return ($result->getMessage());
		
		$this->username = $username;
    }

	function setUsertype($usertype)
    {
        require "config.php";
                
        $query = "UPDATE `users` SET `usertype` = '{$usertype}' WHERE `ID` = {$this->id}";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";            
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
            return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
            return ($result->getMessage());
		
		$this->usertype = $usertype;
    }
	
	function setEmail($email)
    {
        require "config.php";

        $query = "UPDATE `users` SET `email` = '{$email}' WHERE `ID` = {$this->id}";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
            return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
            return ($result->getMessage());

        $this->email = $email;
    }
	
	function checkPassword($password)
	{
		require "config.php";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
            return ($connection->getMessage());

	$result = $connection->query("SELECT * FROM `users` WHERE ID='{$this->id}'");

        if (DB::isError($result))
            return ($result->getMessage());
		
		$salt = "";
		$pass = "";
		
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
        {
			$salt = $row['salt'];
			$pass = $row['password'];
        }
		
		return (hash('sha512', $password . $salt) == $pass);

	}
	
	static function findUsersByName($name)
	{
		require "config.php";

        $query = "SELECT `ID`  FROM `users` WHERE `username` = '{$name}'";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);
        
        if (DB::isError($connection))
        	return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
            return ($result->getMessage());
		
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
            return new User($row['ID']);
	return "No User Found";
	}
	
	static function create($name, $email, $password = "password", $usertype = 0)
	{
		require "config.php";

        $query = "INSERT INTO `users` (`ID`, `username`, `email`, `password`, `salt`, `usertype`) VALUES
(NULL, '{$name}', '{$email}', '', '', 0)";
		$query1 = "SELECT * FROM `users` WHERE Username='{$name}'";
		$dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);

        if (DB::isError($connection))
                return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
                return ($result->getMessage());
		$result = $connection->query($query1);
        if (DB::isError($result))
                return ($result->getMessage());

		$user = null;
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
                $user = new User($row['ID']);
		
		$user->setUsername($name);
		$user->setEmail($email);
		$user->setPassword($password);
		$user->setUsertype($usertype);
		
		return $user;
	}
	
	static function getAllUsers()
	{
		require "config.php";

        $query = "SELECT `ID` FROM `users`";
        $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
        $connection = DB::connect($dsn);
        
        if (DB::isError($connection))
        	return ($connection->getMessage());

        $result = $connection->query($query);
        if (DB::isError($result))
            return ($result->getMessage());
		
		$users = array();

		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
            $users[] = new User($row['ID']);

        return $users;
	}

	
	private static function rand_string ($length) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );
		$str = "";
    	for( $i = 0; $i < $length; $i++ ) {
    		$str .= $chars[ rand( 0, $size - 1 ) ];
        }
    	return $str;
	}

}
#Changing a user password and finding by name
#$user = User::findUsersByName("admin");
#$user->setPassword('password');

//Creating a user
//$user = User::create('test', 'test@test.com');
//if (is_string($user))
//{
//	echo $user;
//	die();
//}
//echo $user->id;

