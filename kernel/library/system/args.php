<?php

class Args {

	private static $requestArgs;
	private static $requestParms;

	public static function GetArgs()
	{
		return self::$requestArgs;
	}
	
	public static function GetParams()
	{
		return self::$requestParms;
	}
	
	public static function Parse()
	{
		$requestUrl	= $_SERVER["REQUEST_URI"];
		
		// Clean up arguments
		$paramPos = strpos($requestUrl, "?");
		if ($paramPos)
			$requestUrl = substr($requestUrl, 0, $paramPos);
		
		self::$requestArgs = explode("/", $requestUrl);
		self::$requestParms = array();
		
		// Clean up arguments
		foreach(self::$requestArgs as $key => $val)
		{
			if (empty($val))
				unset(self::$requestArgs[$key]);
		}
		
		self::$requestArgs = Validate("routeApi", self::$requestArgs);
		
		// Clean up params
		foreach($_GET as $key => $val)
		{
			if (!empty($val))
			{
				self::$requestParms[$key] = $val;
			}
		}
		
		// Clean up params
		foreach($_POST as $key => $val)
		{
			if (!empty($val))
			{
				self::$requestParms[$key] = $val;
			}
		}
	}
};

?>