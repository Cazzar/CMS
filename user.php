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
	}
	function LoadData()
	{
		require "config.php";
		$dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
		$connection = DB::connect($dsn);
		
		if (DB::isError($connection))
			die ($connection->getMessage());

		$result = $connection->query("SELECT * FROM `users` WHERE ID='" . $this->id . "'");
		
                if (DB::isError($result))
                        die ($result->getMessage());

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
                        die ($connection->getMessage());
		
                $result = $connection->query($query);
                if (DB::isError($result))
                        die ($result->getMessage());
	}
	
	function setUsername($username)
        {
                require "config.php";

                $query = "UPDATE `users` SET `username` = '{$username}' WHERE `ID` = {$this->id}";
                $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
                $connection = DB::connect($dsn);

                if (DB::isError($connection))
                        die ($connection->getMessage());

                $result = $connection->query($query);
                if (DB::isError($result))
                        die ($result->getMessage());
		
		$this->username = $username;
        }

	function setUsertype($usertype)
        {
                require "config.php";
                
                $query = "UPDATE `users` SET `usertype` = '{$usertype}' WHERE `ID` = {$this->id}";
                $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";            
                $connection = DB::connect($dsn);

                if (DB::isError($connection))
                        die ($connection->getMessage());

                $result = $connection->query($query);
                if (DB::isError($result))
                        die ($result->getMessage());
		
		$this->usertype = $usertype;
        }
	
	function setEmail($email)
        {
                require "config.php";

                $query = "UPDATE `users` SET `email` = '{$email}' WHERE `ID` = {$this->id}";
                $dsn = "mysql://{$config['mysql_user']}:{$config['mysql_password']}@{$config['mysql_host']}/{$config['mysql_database']}";
                $connection = DB::connect($dsn);

                if (DB::isError($connection))
                        die ($connection->getMessage());

                $result = $connection->query($query);
                if (DB::isError($result))
                        die ($result->getMessage());

                $this->email = $email;
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
