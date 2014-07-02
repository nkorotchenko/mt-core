<?php

require_once( "validation.php" );
require_once( "users.php" );
require_once( "auth.php" );

class Security {
	public static function GetIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	public static function GetSalt($length = 6)
	{
		$chars	= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code	= "";

		$clen = strlen($chars) - 1;  
		while (strlen($code) < $length) {

				$code .= $chars[mt_rand(0,$clen)];  
		}

		return $code;
	}
}

?>