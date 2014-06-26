<?php

require_once( "app.php" );
require_once( "args.php" );
require_once( "route.php" );
require_once( "ini.php" );
require_once( "settings.php" );
require_once( "sql.php" );

class System {
	private static $settings = false;
	private static $sql = false;
	private static $sqlConnection = false;
	private static $args = false;
	public static $startTime;
	
	function __construct()
	{
    }
	
	public static function Init()
	{
		Args::Parse();
		
		self::$startTime = microtime(true);
		self::$settings = new SETTINGS();
		self::$settings->Init();
	}
	
	public static function GetConnect()
	{
		if (!self::$sqlConnection)
		{
			self::$sql = new SQL();
			self::$sqlConnection = self::$sql->Open(self::$settings->Get("data_base"));
			
			if (!self::$sqlConnection)
				return false;
		}
		
		return self::$sql;
	}
	
	public static function Dispose()
	{
		if (self::$sql)
			self::$sql->Close();
	}
	
	public static function RunApp($name, $args = null, $params = null)
	{
		$fileName = PATH_APP.strtolower("/$name/$name.app.php");
	
		if (file_exists($fileName) == false)
			return false;
			
		require_once($fileName);
		
		$className = $name."Application";
		
		$app = false;
		
		if(class_exists($className))
		{
			if ($args == null)
				$args = Args::GetArgs();
				
			if ($params == null)
				$params = Args::GetParams();
				
			$app = new $className();
			$app->path = PATH_APP.strtolower("/$name");
			$app->url = str_replace(PATH_SITE, "", PATH_APP.strtolower("/$name"));
			$app->main($args, $params);
		}
		else
			return false;
		
		return $app;
	}
}

?>