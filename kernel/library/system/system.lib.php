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
	
	public static function GetSettings()
	{
		return self::$settings;
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
	
	public static function Redirect($url)
	{
		header('Location: '.$url);
		exit();
	}
	
	public static function Dispose()
	{
		if (self::$sql)
			self::$sql->Close();
	}
	
	public static function DateAdd($interval, $number, $date)
	{
		$date_time_array = getdate($date);
		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		switch ($interval) {		
			case 'yyyy': $year+=$number; break;
			case 'q': $year+=($number*3); break;
			case 'm': $month+=$number; break;
			case 'y': case 'd': case 'w': $day+=$number; break;
			case 'ww': $day+=($number*7); break;
			case 'h': $hours+=$number; break;
			case 'n': $minutes+=$number; break;
			case 's': $seconds+=$number; break;            
		}
		
		$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		
		return $timestamp;
	}
	
	public static function GetPageClass($args)
	{
		$pageClass = "index";
		
		if (count($args) > 0)
			$pageClass = $args[0];
			
		return $pageClass;
	}
	
	public static function IsPageClass($pageClass, $name)
	{
		return strcmp($pageClass, $name) == 0;
	}
	
	public static function IsAppExist($name)
	{
		$fileName = PATH_APP.strtolower("/$name/$name.app.php");
	
		if (file_exists($fileName) == false)
			return false;
			
		require_once($fileName);
		
		$className = $name."Application";
		
		$app = false;
		
		if(class_exists($className))
		{
			return true;
		}
		
		return false;
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
			if (empty($args))
				$args = Args::GetArgs();
				
			if (empty($params))
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